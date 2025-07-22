<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;
use Termwind\Components\Ul;

class AuthController extends Controller
{
    public function login_admin()
    {
        if(!empty(Auth::check()) && Auth::user()->is_admin == 1)
        {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }

   public function auth_login_admin(Request $request)
{
    $remember = $request->remember ? true : false;

    if (Auth::guard('admin')->attempt([
        'email' => $request->email,
        'password' => $request->password,
        'is_admin' => 1,
        'status' => 0,
        'is_delete' => 0
    ], $remember)) {
        return redirect('admin/dashboard');
    } else {
        return redirect()->back()->with('error', 'Kata sandi atau email salah');
    }
}

public function logout_admin()
{
    Auth::guard('admin')->logout();
    return redirect(url('admin'));
}
    public function auth_login(Request $request)
{
    $remember = $request->is_remember ? true : false;

    if (Auth::guard('web')->attempt([
        'email' => $request->email,
        'password' => $request->password,
        'status' => 0,
        'is_delete' => 0
    ], $remember)) {
        if (!empty(Auth::guard('web')->user()->email_verified_at)) {
            return response()->json(['status' => true, 'message' => 'Login berhasil']);
        } else {
            $save = User::getSingle(Auth::guard('web')->id());
            Mail::to($save->email)->send(new RegisterMail($save));
            Auth::guard('web')->logout();

            return response()->json([
                'status' => false,
                'message' => 'Harap verifikasi email Anda. Silakan periksa email Anda untuk tautan verifikasi.'
            ]);
        }
    }

    return response()->json([
        'status' => false,
        'message' => 'Kata sandi atau email salah'
    ]);
}

public function logout_customer()
{
    Auth::guard('web')->logout();
    return redirect('/');
}

    public function auth_register(Request $request)
    {
        $checkEmail = User::checkEmail($request->email);
        if(empty($checkEmail))
        {

            $save = new User();
            $save->name = trim($request->name);
            $save->email = trim($request->email);
            $save->password = Hash::make($request->password);
            $save->save();

            Mail::to($save->email)->send(new RegisterMail($save));

            $json['status'] = true;
            $json['message'] = 'Pendaftaran berhasil, silakan periksa email Anda untuk verifikasi';
        }
        else{
            $json['status'] = false;
            $json['message'] = 'Email sudah ada';
        }
        echo json_encode($json);
    }
    //     public function logout_customer()
    // {
    //     Auth::logout();
    //     return redirect('/');
    // }
    public function activate_email($id)
    {
        $id = base64_decode($id);
        $user = User::getSingle($id);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect(url(''))->with('success', 'Email berhasil diverifikasi');
    }
    public function forgot_password(Request $request)
    {
        $data['meta_title'] = 'Forgot Password';
        return view('auth.forgot-password', $data);
    }
    public function auth_forgot_password(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if(!empty($user))
        {
            $user->remember_token = Str::random(60);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'Silakan periksa email Anda untuk mengatur ulang kata sandi Anda');
        }
        else
        {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
    }
    public function reset($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if(!empty($user))
        {
            $data['user'] = $user;
            $data['meta_title'] = 'Reset Password';
            return view('auth.reset', $data);
        }
        else
        {
            abort(404);
        }
    }
    public function auth_reset(Request $request, $token)
    {
        if($request->password == $request->cpassword)
        {
            $user = User::where('remember_token', '=', $token)->first();
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();

            return redirect(url(''))->with('success', 'Reset kata sandi berhasil, silakan masuk kembali');
        }
        else
        {
            return redirect()->back()->with('error', 'Kata sandi dan konfirmasi kata sandi tidak cocok');
        }
    }
}
