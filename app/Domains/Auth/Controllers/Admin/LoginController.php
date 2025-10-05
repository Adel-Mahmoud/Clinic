<?php

namespace App\Domains\Auth\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Domains\Auth\Models\Admin;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth.admin')->except('logout');
    // }
    
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            if (Route::has('admin.dashboard')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/admin/dashboard');
        }
        return view('auth::admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            if (Route::has('admin.dashboard')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function showRegisterForm()
    {
        return view('auth::admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);
        
        return redirect()->route('/admin/dashboard');
    }
}
