<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Uang_Keluar;
use App\Models\Uang_Masuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->with('success', 'You have successfully logged in');
        }

        return redirect("login")->with('error', 'Oops! Invalid credentials');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $this->create($data);

        return redirect("dashboard")->with('success', 'Great! You have successfully registered and logged in');
    }

    public function dashboard()
    {
        $uangMasuks = $this->formatuang(Uang_Masuk::sum("jumlah"));
        $uangKeluars = $this->formatuang(Uang_Keluar::sum("jumlah"));
        $users = User::count();

        $total = floatval($uangMasuks) + floatval($uangKeluars);
        $total = number_format($total, 3, '.', '');


        if (Auth::check()) {
            return view('auth.dashboard', compact('uangMasuks', 'uangKeluars', 'users','total'));
        }

        return redirect("login")->with('error', 'Oops! You do not have access');
    }

    public function formatuang($uang)
    {
        return number_format($uang, 0, ',', '.');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
