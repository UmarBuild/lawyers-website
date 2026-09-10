<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Home page — featured lawyers, services, total lawyer count, editable hero text.
     */
    public function index()
    {
        $featuredLawyers = User::where('role', 'lawyer')
            ->where('is_approved', true)
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        $services = Service::orderBy('name')->get();

        $totalLawyers = User::where('role', 'lawyer')->where('is_approved', true)->count();

        // Pull admin-editable homepage content from site_settings table.
        $heroTitle    = SiteSetting::get('hero_title');
        $heroSubtitle = SiteSetting::get('hero_subtitle');
        $statOnlineValue = SiteSetting::get('stat_online_value');
        $statOnlineLabel = SiteSetting::get('stat_online_label');

        return view('home', compact(
            'featuredLawyers',
            'services',
            'totalLawyers',
            'heroTitle',
            'heroSubtitle',
            'statOnlineValue',
            'statOnlineLabel'
        ));
    }

    /**
     * Static About page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Static Privacy Policy page.
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Static Terms & Conditions page.
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Contact page (form display).
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Store a contact form submission.
     */
    public function storeContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'subject'      => $request->subject,
            'message'      => $request->message,
            'submitted_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Message sent successfully! We will get back to you soon.');
    }

    /**
     * Customer dashboard — recent appointments overview.
     */
    public function customerDashboard()
    {
        $user = auth()->user();
        $appointments = $user->customerAppointments()->orderByDesc('created_at')->take(5)->get();

        return view('customer.dashboard', compact('user', 'appointments'));
    }

    /**
     * Show the customer profile edit form.
     */
    public function editCustomerProfile()
    {
        $user = auth()->user();
        return view('customer.edit-profile', compact('user'));
    }

    /**
     * Update the customer profile.
     * Only basic profile fields are editable; email/password are intentionally
     * excluded for security reasons.
     */
    public function updateCustomerProfile(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'city'    => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the change-password form for the logged-in customer.
     */
    public function editPassword()
    {
        return view('customer.change-password');
    }

    /**
     * Update the logged-in customer's password.
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'current_password'          => 'required|string',
            'password'                  => 'required|string|min:8|confirmed',
            'password_confirmation'     => 'required|string',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Password changed successfully.');
    }
}
