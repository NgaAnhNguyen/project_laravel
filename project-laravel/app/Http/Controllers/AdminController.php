<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Social;
use App\Rules\Captcha;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

session_start();
class AdminController extends Controller
{   

    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }
        else {
            $hieu = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);
    
            $orang = Login::where('admin_email',$users->email)->first();
    
                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
    
                        'admin_phone' => '',
                        'admin_status' => 1
                    ]);
                }
            $hieu->login()->associate($orang); 
            $hieu->save();
    
           return $hieu;
        }

    }

    public function AuthLogin() {
        if(Session::get('admin_id') != null) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function index() {
        return view('admin-login');
    }
    public function admin_layout() {
        $this->AuthLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request) {
        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),
        ]);
    
        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
    
        $result = Login::where('admin_email', $admin_email)
                       ->where('admin_password', $admin_password)
                       ->first();
    
        if ($result) {
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        } else {
            Session::put('message', 'Mật khẩu hoặc tài khoản không đúng, vui lòng nhập lại!');
            return Redirect::to('/admin');
        }
    }
    public function logout() {
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

       
    
}
