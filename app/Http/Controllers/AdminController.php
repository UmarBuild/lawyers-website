<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\ContactMessage;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalLawyers = User::where('role', 'lawyer')->count();
        $pendingLawyers  = User::where('role', 'lawyer')->where('is_approved', false)->count();
        $totalAppointments    = Appointment::count();
        $pendingAppointments  = Appointment::where('status', 'pending')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();

        $recentAppointments = Appointment::orderByDesc('created_at')->take(5)->get();
        $recentLawyers = User::where('role', 'lawyer')->orderByDesc('created_at')->take(5)->get();
        // $unreadMessages = ContactMessage::where('is_read', false)->count(); 

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
    public function manageUsers(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $users = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.users', compact('users'));
    }
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
    public function manageAppointments()
    {
        $appointments = Appointment::with(['lawyer', 'customer'])->orderByDesc('created_at')->paginate(15);

        return view('admin.appointments', compact('appointments'));
    }
    public function manageServices()
    {
        $services = Service::orderBy('name')->get();
        return view('admin.services', compact('services'));
    }
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:services,name'
        ]);

        Service::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Service added successfully.');
    }
      public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted.');
    }
      public function contactMessages()
    {
        $messages = ContactMessage::orderByDesc('submitted_at')
                                   ->paginate(20);

        return view('admin.messages', compact('messages'));
    }
    public function destroyMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
         return redirect()->back()->with('success', 'Message deleted.');
    }
}
