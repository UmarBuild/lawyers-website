<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\ContactMessage;
use App\Models\Notification;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin dashboard — high-level stats and recent activity.
     */
    public function dashboard()
    {
        $totalCustomers         = User::where('role', 'customer')->count();
        $totalLawyers           = User::where('role', 'lawyer')->count();
        $pendingLawyers         = User::where('role', 'lawyer')->where('is_approved', false)->count();
        $totalAppointments      = Appointment::count();
        $pendingAppointments    = Appointment::where('status', 'pending')->count();
        $completedAppointments  = Appointment::where('status', 'completed')->count();

        $recentAppointments = Appointment::orderByDesc('created_at')->take(5)->get();
        $recentLawyers      = User::where('role', 'lawyer')->orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalLawyers',
            'pendingLawyers',
            'totalAppointments',
            'pendingAppointments',
            'completedAppointments',
            'recentAppointments',
            'recentLawyers'
        ));
    }

    /**
     * Manage lawyers — filterable by approval status and searchable by name.
     */
    public function manageLawyers(Request $request)
    {
        $query = User::where('role', 'lawyer');

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $lawyers = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.lawyers', compact('lawyers'));
    }

    /**
     * Approve a lawyer registration and notify them.
     */
    public function approveLawyer($id)
    {
        $lawyer = User::findOrFail($id);

        $lawyer->update(['is_approved' => true]);

        Notification::create([
            'user_id' => $lawyer->id,
            'type'    => 'lawyer_approved',
            'message' => 'Congratulations! Your lawyer account has been approved by admin. You can now access your dashboard.',
            'link'    => '/lawyer/dashboard',
            'is_read' => false,
        ]);

        return redirect()->back()
            ->with('success', "Lawyer '{$lawyer->name}' approved successfully.");
    }

    /**
     * Reject (revoke approval for) a lawyer and notify them.
     */
    public function rejectLawyer($id)
    {
        $lawyer = User::findOrFail($id);

        $lawyer->update(['is_approved' => false]);

        Notification::create([
            'user_id' => $lawyer->id,
            'type'    => 'lawyer_rejected',
            'message' => 'Your lawyer account registration has been rejected. Please contact admin for details.',
            'link'    => '/contact',
            'is_read' => false,
        ]);

        return redirect()->back()
            ->with('success', "Lawyer '{$lawyer->name}' has been rejected.");
    }

    /**
     * Manage customers — searchable by name.
     */
    public function manageUsers(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $users = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Delete a user (and their appointments + notifications) — admins cannot be deleted.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            abort(403, 'Cannot delete admin account.');
        }

        Appointment::where('lawyer_id', $id)->orWhere('customer_id', $id)->delete();
        Notification::where('user_id', $id)->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    /**
     * View all appointments across the platform.
     */
    public function manageAppointments()
    {
        $appointments = Appointment::with(['lawyer', 'customer'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.appointments', compact('appointments'));
    }

    /**
     * Manage service categories.
     */
    public function manageServices()
    {
        $services = Service::orderBy('name')->get();
        return view('admin.services', compact('services'));
    }

    /**
     * Store a new service category.
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:services,name',
        ]);

        Service::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Service added successfully.');
    }

    /**
     * Delete a service category.
     */
    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted.');
    }

    /**
     * View contact-form submissions.
     */
    public function contactMessages()
    {
        $messages = ContactMessage::orderByDesc('submitted_at')->paginate(20);
        return view('admin.messages', compact('messages'));
    }

    /**
     * Delete a contact-form submission.
     */
    public function destroyMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message deleted.');
    }

    /**
     * Show the homepage content editor (hero text, stats label, footer content).
     */
    public function editContent()
    {
        $settings = [];
        foreach (SiteSetting::DEFAULTS as $key => $default) {
            $settings[$key] = SiteSetting::get($key, $default);
        }

        return view('admin.content', compact('settings'));
    }

    /**
     * Update homepage content (admin-editable site settings).
     */
    public function updateContent(Request $request)
    {
        $validated = $request->validate([
            'hero_title'        => 'required|string|max:120',
            'hero_subtitle'     => 'required|string|max:255',
            'stat_online_value' => 'required|string|max:30',
            'stat_online_label' => 'required|string|max:60',
            'footer_about'      => 'required|string|max:300',
            'footer_email'      => 'required|email|max:120',
            'footer_phone'      => 'required|string|max:30',
            'footer_address'    => 'required|string|max:120',
        ]);

        SiteSetting::setMany($validated);
        SiteSetting::flushCache();

        return redirect()->route('admin.content')
            ->with('success', 'Homepage content updated successfully.');
    }
}
