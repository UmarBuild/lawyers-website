<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // lawyer Data With Booked Appointments
  public function create($lawyerId){
    $lawyer = User::findOrFail($lawyerId);
    if(!$lawyer->islawyer() || !$lawyer->isApproved()){
        abort(404,'lawyer not found');
        };
       $availableDays =  $lawyer->getAvailableDays();
       $bookedDates = $lawyer->lawyerAppointments()->where('status','approved')->pluck('appointment_date')->unique()->values()->map(fn($date) => $date->format('Y-m-d'))->toArray();

         return view('appointments.create', compact(
            'lawyer', 'availableDays', 'bookedDates'
        ));
  }
  public function store(Request $request){
 $request->validate([
    'lawyer_id' => 'required|exists:users,id|integer',
    'appointment_date' => 'required|after:today|date',
    'appointment_time' => 'required|date_format:H:i',
    'message'          => 'nullable|string|max:1000',
 ]);
 $exists = Appointment::where('lawyer_id', $request->lawyer_id)->where('appointment_date', $request->appointment_date)->where('appointment_time', $request->appointment_time)->exists();
 if($exists){
    return redirect()->back()->with('error', 'You already have an appointment at this date and time.')->withInput();
 }
$customer = Auth::user();
   $appointment = Appointment::create([
            'lawyer_id'        => $request->lawyer_id,
            'customer_id'      => $customer->id,     
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message'          => $request->message,
            'status'           => 'pending',   
        ]);
        Notification::create([
            'user_id' => $request->lawyer_id,
            'type'    => 'appointment_booked',
            'message' => "New appointment request from {$customer->name} on {$request->appointment_date}.",
            'link'    => '/lawyer/appointments',
            'is_read' => false,
        ]); 
        $lawyer = User::find($request->lawyer_id);
         Notification::create([
            'user_id' => $customer->id,
            'type'    => 'appointment_booked',
            'message' => "Your appointment request with {$lawyer->name} has been sent. Waiting for approval.",
            'link'    => '/my-appointments',
            'is_read' => false,
        ]);
 return redirect()->route('my-appointments')->with('success', 'Appointment booked successfully! Waiting for lawyer approval.');
  }

    public function myAppointments(){
        $appointments = Auth::user()->customerAppointments()->orderByDesc('created_at')->paginate(10);

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
       public function show($id){
        $appointment = Appointment::findOrFail($id);
        if ($appointment->lawyer_id !== Auth::id() && $appointment->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }
        return view('appointments.show', compact('appointment'));

    }
    // mark notification as read
    public function markNotificationRead($id)
{
    $notification = Notification::findOrFail($id);

    if ($notification->user_id !== auth()->id()) {
        abort(403);
    }

    $notification->update(['is_read' => true]);

    return back();
}
    }
