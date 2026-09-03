<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredLawyers = User::where('role', 'lawyer')->where('is_approved', true)->orderByDesc('rating')->take(6)->get();

        $services = Service::orderBy('name')->get();

        $totalLawyers = User::where('role', 'lawyer')->where('is_approved', true)->count();

        return view('home', compact(
            'featuredLawyers', 'services', 'totalLawyers'
        ));
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'subject'     => $request->subject,
            'message'     => $request->message,
            'submitted_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Message sent successfully! We will get back to you soon.');
    }

    public function customerDashboard()
    {
        $user = auth()->user();
        $appointments = $user->customerAppointments()->orderByDesc('created_at')->take(5)->get();

        return view('customer.dashboard', compact('user', 'appointments'));
    }
}