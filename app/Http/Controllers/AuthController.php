<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected $AuthService;

    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }

    public function pageLogin()
    {
        return view("user.auth.login");
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]); 

        $email = $request->input('email');
        $password = $request->input('password');

        if ($this->AuthService->login($email, $password)) {
            if (Auth::user()->role == 0) {
                return $this->successRedirect('home_admin', 'Đăng nhập thành công, chào mừng bạn!');
            } else {
               return $this->successRedirect('home', 'Đăng nhập thành công, chào mừng bạn!');
            }
        }
        return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không đúng, thử lại đi!');
    }

    public function logout(Request $request)
    {
        $this->AuthService->logout();
        return $this->successRedirect('home', 'Đăng xuất thành công!');
    }

    public function register()
    {
        return view('user.auth.register');
    }

    public function checkRegister(Request $request)
    {
        try {
            if ($this->AuthService->checkRegister($request)) {
               return $this->successRedirect('pageLogin', 'Đăng ký thành công, hãy đăng nhập!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        return $this->errorRedirect('register', 'Đăng ký thất bại, thử lại đi!');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $success = $this->AuthService->handleGoogleCallback();

            if ($success) {
              
                return $this->successRedirect('home', 'Đăng nhập bằng Google thành công!');
            }

            return $this->errorRedirect('home', 'Đăng nhập bằng Google thất bại!');
        } catch (Exception $e) {
            Log::error('Google Callback Error: ' . $e->getMessage());
            return $this->errorRedirect('home', 'Đăng nhập bằng Google thất bại!'. $e->getMessage());
        }
    }
}
