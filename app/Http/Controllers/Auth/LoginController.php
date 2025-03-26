<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        $user = User::where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if ($user) {
            if ($user->role === 'user') {
                $loginAttempt = Hash::check($credentials['password'], $user->password);
            } else {
                $loginAttempt = $credentials['password'] === $user->password;
            }
        } else {
            $loginAttempt = false;
        }

        if ($loginAttempt) {
            Auth::login($user);
            $request->session()->regenerate();

            // Simpan cookie jika "Ingat Selalu" dicentang
            if ($request->has('remember')) {
                Cookie::queue('username', $request->username, 60 * 24 * 30); // 30 hari
                Cookie::queue('password', $request->password, 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('username'));
                Cookie::queue(Cookie::forget('password'));
            }

            $role = $user->role;
            switch ($role) {
                case 'user':
                    return redirect()->route('/');
                case 'perawat':
                    return redirect()->route('perawat.index');
                case 'dokter':
                    return redirect()->route('dokter.index');
                case 'apoteker':
                    return redirect()->route('apotek.index');
                case 'kasir':
                    return redirect()->route('kasir.index');
                case 'admin':
                    return redirect()->route('admin.dashboard');
            }
        } else {
            return redirect()->back()->withErrors(['username' => 'The provided credentials are incorrect.']);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login/index');
    }
}
