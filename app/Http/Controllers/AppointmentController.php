<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function create($lawyerId)
    {
        $lawyer = User::findOrFail($lawyerId);

        if (!$lawyer->isLawyer() || !$lawyer->isApproved()) {
            abort(404, 'Lawyer not found.');
        }

        $availableDays = $lawyer->getAvailableDays();

        $bookedDates = $lawyer->lawyerAppointments()
            ->where('status', 'approved')
            ->get()
            ->pluck('appointment_date')
            ->unique()
            ->values()
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

        return view('appointments.create', compact(
            'lawyer', 'availableDays', 'bookedDates'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id'        => 'required|exists:users,id|integer',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'message'          => 'nullable|string|max:1000',
        ]);

        $customer = Auth::user();
        $cleanTime = date('H:i', strtotime($request->appointment_time));

        // 1. Check if the lawyer already has an ACTIVE (pending or approved) appointment in this slot
        $lawyerSlotOccupied = Appointment::where('lawyer_id', $request->lawyer_id)
            ->where('appointment_date', $request->appointment_date)
            ->where(function($query) use ($cleanTime) {
                $query->where('appointment_time', $cleanTime)
                      ->orWhere('appointment_time', $cleanTime . ':00');
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($lawyerSlotOccupied) {
            return redirect()->back()
                ->with('error', 'This appointment slot is already booked for this advocate. Please select another date or time.')
                ->withInput();
        }

        // 2. Check if the customer themselves already booked an active appointment at this date & time
        $customerHasConflict = Appointment::where('customer_id', $customer->id)
            ->where('appointment_date', $request->appointment_date)
            ->where(function($query) use ($cleanTime) {
                $query->where('appointment_time', $cleanTime)
                      ->orWhere('appointment_time', $cleanTime . ':00');
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($customerHasConflict) {
            return redirect()->back()
                ->with('error', 'You already have an active appointment booked at this date and time.')
                ->withInput();
        }

        // 3. Atomically create appointment and notifications in a transaction
        DB::transaction(function() use ($request, $customer, $cleanTime) {
            $appointment = Appointment::create([
                'lawyer_id'        => $request->lawyer_id,
                'customer_id'      => $customer->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $cleanTime,
                'message'          => $request->message,
                'status'           => 'pending',
            ]);

            $lawyer = User::find($request->lawyer_id);

            // Notify lawyer
            Notification::create([
                'user_id' => $request->lawyer_id,
                'type'    => 'appointment_booked',
                'message' => "New appointment request from {$customer->name} on {$request->appointment_date} at " . date('h:i A', strtotime($cleanTime)) . ".",
                'link'    => '/lawyer/appointments',
                'is_read' => false,
            ]);

            // Notify customer
            Notification::create([
                'user_id' => $customer->id,
                'type'    => 'appointment_booked',
                'message' => "Your appointment request with {$lawyer->name} for {$request->appointment_date} has been sent. Waiting for approval.",
                'link'    => '/my-appointments',
                'is_read' => false,
            ]);
        });

        return redirect()->route('my-appointments')
            ->with('success', 'Appointment booked successfully! Waiting for lawyer approval.');
    }

    public function myAppointments()
    {
        $appointments = Auth::user()
            ->customerAppointments()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('appointments.my-appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->lawyer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,completed',
        ]);

        $appointment->update(['status' => $request->status]);

        $lawyer = Auth::user();
        $statusText = $request->status;

        Notification::create([
            'user_id' => $appointment->customer_id,
            'type'    => 'appointment_' . $statusText,
            'message' => "Your appointment with {$lawyer->name} on {$appointment->formattedDateTime()} has been {$statusText}.",
            'link'    => '/my-appointments',
            'is_read' => false,
        ]);

        return redirect()->back()
            ->with('success', "Appointment {$statusText} successfully.");
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($appointment->status, ['pending', 'approved'])) {
            return redirect()->back()
                ->with('error', 'This appointment cannot be cancelled anymore.');
        }

        $appointment->update(['status' => 'cancelled']);

        $customer = Auth::user();
        Notification::create([
            'user_id' => $appointment->lawyer_id,
            'type'    => 'appointment_cancelled',
            'message' => "{$customer->name} has cancelled the appointment on {$appointment->formattedDateTime()}.",
            'link'    => '/lawyer/appointments',
            'is_read' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->lawyer_id !== Auth::id() && $appointment->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        return view('appointments.show', compact('appointment'));
    }

    public function rate(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($appointment->status !== 'completed') {
            return redirect()->back()
                ->with('error', 'You can only rate completed appointments.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $appointment->update(['customer_rating' => $request->rating]);

        $lawyer = $appointment->lawyer;
        $avg = Appointment::where('lawyer_id', $lawyer->id)
            ->whereNotNull('customer_rating')
            ->avg('customer_rating');
        $lawyer->update(['rating' => round($avg, 1)]);

        return redirect()->back()
            ->with('success', 'Thank you for your rating!');
    }

    public function markNotificationRead($id)
    {
        if ($id === 'all') {
            Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => true]);
            }

            return back();
        }

        $notification = Notification::findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}