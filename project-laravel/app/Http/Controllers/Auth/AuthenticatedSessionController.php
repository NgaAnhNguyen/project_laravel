<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $email = $request->email_account;
        $password = $request->password_account;
    
        // Lấy thông tin khách hàng từ cơ sở dữ liệu
        $result = DB::table('tbl_customers')->where('customer_email', $email)->first();
        
        if ($result && Hash::check($password, $result->customer_password)) {
            // Nếu mật khẩu đúng, lưu thông tin vào session và chuyển hướng
            Auth::loginUsingId($result->customer_id);
            
            Session::put('customer_id', $result->customer_id);
            Session::put('customer_name', $result->customer_name);
            return redirect()->intended(route('dashboard', absolute: false));
        } else {
            // Nếu thông tin đăng nhập sai, hiển thị thông báo lỗi
            Session::put('message', 'Mật khẩu hoặc tài khoản không đúng, vui lòng nhập lại!');
            return redirect()->intended(route('login', absolute: false));
        }
        
    }
  

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
