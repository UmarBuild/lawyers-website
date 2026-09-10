<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class LawyerController extends Controller
{
    /**
     * Public lawyer search page.
     * Supports filtering by name, city, specialization, and sorting
     * by rating / experience / fee. Only approved lawyers are shown.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'lawyer')->where('is_approved', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        if ($request->filled('sort')) {
            if ($request->sort == 'rating') {
                $query->orderBy('rating', 'desc');
            }
            if ($request->sort == 'experience') {
                $query->orderByDesc('experience_years');
            }
            if ($request->sort == 'fee_low') {
                $query->orderBy('consultation_fee', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $lawyers = $query->paginate(10);

        // Build the filter dropdown options.
        $cities = User::where('role', 'lawyer')
            ->where('is_approved', true)
            ->pluck('city')
            ->unique()
            ->sort()
            ->values();

        $specializations = Service::orderBy('name')->pluck('name');

        return view('lawyers.index', compact('lawyers', 'cities', 'specializations'));
    }

    /**
     * Show a single lawyer's public profile.
     */
    public function show($id)
    {
        $lawyer = User::findOrFail($id);

        if (!$lawyer->isLawyer() || !$lawyer->isApproved()) {
            abort(404, 'Lawyer not found.');
        }

        return view('lawyers.show', compact('lawyer'));
    }

    /**
     * Lawyer dashboard — recent appointments, stats, unread notifications.
     */
    public function dashboard()
    {
        $lawyer = auth()->user();

        $appointments = $lawyer->lawyerAppointments()
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $totalAppointments    = $lawyer->lawyerAppointments()->count();
        $pendingAppointments  = $lawyer->lawyerAppointments()->where('status', 'pending')->count();
        $approvedAppointments = $lawyer->lawyerAppointments()->where('status', 'approved')->count();
        $completedAppointments = $lawyer->lawyerAppointments()->where('status', 'completed')->count();

        $unreadNotifications = $lawyer->notifications()
            ->where('is_read', false)
            ->orderByDesc('created_at')
            ->get();

        return view('lawyer.dashboard', compact(
            'lawyer',
            'appointments',
            'totalAppointments',
            'pendingAppointments',
            'approvedAppointments',
            'completedAppointments',
            'unreadNotifications'
        ));
    }

    /**
     * Show the lawyer profile edit form.
     */
    public function editProfile()
    {
        $lawyer = auth()->user();
        $services = Service::orderBy('name')->pluck('name');

        return view('lawyer.edit-profile', compact('lawyer', 'services'));
    }

    /**
     * Update the lawyer profile.
     * Email, password, role, approval, bar council number and rating are
     * intentionally excluded from mass assignment here.
     */
    public function updateProfile(Request $request)
    {
        $lawyer = auth()->user();

        $rules = [
            'name'                 => 'required|string|max:255',
            'phone'                => 'required|string|max:20',
            'city'                 => 'required|string|max:100',
            'address'              => 'nullable|string|max:500',
            'specialization'       => 'required|string|max:100',
            'qualification'        => 'required|string|max:200',
            'experience_years'     => 'required|integer|min:0|max:50',
            'consultation_fee'     => 'required|integer|min:0',
            'available_days'       => 'nullable|array',
            'available_time_start' => 'nullable|date_format:H:i',
            'available_time_end'   => 'nullable|date_format:H:i',
        ];

        $request->validate($rules);

        $data = $request->except([
            'email', 'password', 'role', 'is_approved',
            'bar_council_number', 'rating',
        ]);

        // Store available_days as JSON-encoded array (User::getAvailableDays decodes it).
        if ($request->has('available_days')) {
            $data['available_days'] = json_encode($request->available_days);
        }

        $lawyer->update($data);

        return redirect()->route('lawyer.dashboard')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * List the lawyer's appointments, optionally filtered by status.
     */
    public function appointments(Request $request)
    {
        $lawyer = auth()->user();

        $query = $lawyer->lawyerAppointments()->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(10);

        return view('lawyer.appointments', compact('appointments'));
    }
}
