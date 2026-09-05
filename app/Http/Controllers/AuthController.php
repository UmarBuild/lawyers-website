<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        $services = \App\Models\Service::all();
        return view('register', compact('services'));
    }
    public function storeRegistration(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required|in:customer,lawyer'
        ];
        if ($request->role === 'lawyer') {
            $rules['phone']             = 'required|string|max:20';
            $rules['city']             = 'required|string|max:100';
            $rules['specialization']   = 'required|string|max:100';
            $rules['qualification']    = 'required|string|max:200';
            $rules['experience_years'] = 'required|integer|min:0|max:50';
            $rules['consultation_fee'] = 'required|integer|min:0';
            $rules['bar_council_number'] = 'required|string|max:100|unique:users,bar_council_number';
        }
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }; 
        $data = $request->only([
              'name', 'email', 'password', 'role',
            'phone', 'city', 'address', 'specialization',
            'qualification', 'experience_years', 'consultation_fee',
            'bar_council_number', 'available_days',
            'available_time_start', 'available_time_end'
        ]);
        $data['password'] = Hash::make($request->password); 
          if ($request->role === 'lawyer') {
            $data['is_approved'] = false; 
            $data['rating'] = 0.0; 
        }
        $user = User::create($data);
        if($user->isLawyer()){
            $admin = User::where('role','admin')->first(); 
            if($admin){
                Notification::create([
                  'user_id' => $admin->id,
                    'type'    => 'new_lawyer_registration',
                    'message' => "New lawyer '{$user->name}' has registered and needs approval.",
                    'link'    => '/admin/lawyers',
                    'is_read' => false,
            ]);
            };
    };
    return redirect()->route('login')->with('success', 'Registration successful! Please login');
    }
    public function showLogin(){
        if(Auth::check()){
          return redirect($this->getDashboardRoute());
        }
        return view('login');
    }
    public function Authenticate(Request $request){
         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
         ]);
         if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->isLawyer() && !$user->isApproved()){
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is pending admin ]approval.');
                }
                return redirect($this->getDashboardRoute());
                }
                   return redirect()->route('login')->with('error', 'Invalid email or password.');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You Have Been Logout');
    }
    public function getDashboardRoute(){
      $user = Auth::user();
      return match($user->role){
        'admin' => '/admin/dashboard',
        'lawyer' => '/lawyer/dashboard',
        'customer' => '/customer/dashboard',
      };
    } 
}