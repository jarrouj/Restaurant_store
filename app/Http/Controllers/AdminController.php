<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function AdminLogin(){
        return view('admin.login');
    }
    public function AdminDashboard(){
        return view('admin.index');
    }

    public function AdminLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data  = [
            'email' => $check['email'],
            'password' => $check['password']
        ];
        if(Auth::guard('admin')->attempt($data)){
            return redirect()->route('admin.dashboard')->with('success' , 'Login Successfully');
        }else{
            return redirect()->route('admin.login')->with('error' , 'Invalid Credentials');
        }
    }

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success' , 'Logout Successfully');

    }

    public function AdminProfile()
    {
        $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);

        return view('admin.admin_profile' , compact('profileData'));
    }
}
