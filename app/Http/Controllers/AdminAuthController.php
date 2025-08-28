<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class AdminAuthController extends Controller
{
    // Show register page
    public function showRegister()
    {
        return view('admin.register');
    }

    // Modify register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    // Modify login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    // Show login page
    public function showLogin()
    {
        return view('admin.login');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    public function dashboard()
    {
       $conversions = DB::table('conversions')
        ->leftJoin('offer_clicks', function ($join) {
            $join->on('conversions.campaign_id', '=', 'offer_clicks.campaign_id')
                ->on('conversions.user_id', '=', 'offer_clicks.p2');
        })
        ->select('conversions.*', 'offer_clicks.upi_id')
        ->orderBy('conversions.id', 'desc')
        ->limit(20)
        ->get();

        return view('admin.dashboard', compact('conversions'));
    }
}
