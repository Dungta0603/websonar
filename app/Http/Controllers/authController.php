<?php

namespace App\Http\Controllers;
use App\Jobs\SendEmail;
use App\Models\User;
use App\Models\VerifyEmail;
use App\Service\admin\UserService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class authController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function register(){
        return view('register');
    }


    public function doRegister(Request $request){

        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|same:password',
            ];
            $messages = [
                'required' => 'Không được để trống trường này',
                'min' => 'Mật khẩu tối thiểu phải 6 kí tự',
                'email' => 'Phải nhập đúng định dạng email',
                'same:password' => 'Mật khẩu nhập phải trùng khớp',
                'unique:users' => 'Đã bị trùng email',
            ];
            $request->validate($rules, $messages);
        }

        try{
            DB::beginTransaction();
            $data = $request->all();
            $user =  $this->userService->store($data);
            DB::commit();
            return redirect('/verification/' .$user);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function login(){
//        if(Auth::check()){
//            return redirect()->back()->with('error' , 'Bạn cần phải logout');
//        }else{
            return view('login');
//        }
    }

    public function doLogin(Request $request){
        $credentials = request(['email', 'password']);
        $remember = $request->has('remember_me') ? true : false;
        if (Auth::attempt($credentials ,$remember)) {
            $user = $this->userService->getOne(Auth::user()->id);
            if ($user->is_verified == 1) {
                if ($user->roles) {
                    if ($user->hasRole('user')) {
                        return redirect('/');
                    } else {
                        return redirect('/admin/dashboard');
                    }
                } else {
                    return redirect('/login')->with('error', 'Role not found.');
                }
            }else{
                return redirect('verification/' . $user->id)->with('error', 'Bạn cần phải xác thực email');
            }
         }else{
             return redirect('/login')->with('error', 'Mật khẩu hoặt email không đúng');
         }
    }

    public function logout(){
        Auth::logout();
        return redirect()->to(route('login'));
    }

    public function verification($id){
        $user = User::find($id);
        $this->sendOTP($user);
        return view('verify', compact('user'));
    }

    public function sendOTP($user) {
        $otp = rand(100000, 999999);
        $time = time();

        $verifyEmail = VerifyEmail::updateOrCreate(
              ['email' => $user->email],
              [
                  'email' => $user->email,
                  'otp' => $otp,
                  'user_id' => $user->id,
                  'setup_time' => $time,
              ]
        );
        $data = [
            'title' => 'Mã OTP của NEWS',
            'body' => 'Mã OTP của bạn là:' . $otp,
        ];
        SendEmail::dispatch($data, $user)->delay(now()->addSecond(6));

    }

    public function verifiedOTP(Request $request) {
        $user = User::where('email' , '=', $request->email)->first();

        if (!( VerifyEmail::where('otp' , $request->otp)->first())) {
            return response()->json(['success' => false, 'message' => 'Nhập sai mã  OTP']);
        } else {
            $otpData =  VerifyEmail::where('otp' , $request->otp)->first();
            $currentTime = time();
            $time = $otpData->setup_time;
            if ($currentTime >= $time && $time >= $currentTime - (90+5) ) {
                if (Session::get('password')) {
                    $user->update([
                        'password' => Hash::make(session('password')),
                        'is_verified' => 1,
                    ]);
                    session()->forget('password');
                } else {
                    $user->update([
                        'is_verified' => 1,
                    ]);
                }

                $user->save();
                if ($user->role->name == 'user') {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Đã xác thực thành công',
                        'role' => 'user',
                    ]);
                } else {
                    return response()->json(
                        [
                            'success' => true,
                            'message' => 'Đã xác thực thành công',
                            'role' => 'other',
                        ]);
                }
            }else {
                return response()->json(['success' => false, 'message' => 'Đã quá thời gian']);
            }
        }
    }

    public function resendOTP($email): \Illuminate\Http\RedirectResponse
    {
        $user = User::where('email', $email)->first();
        $otpData = VerifyEmail::where('email', $email)->first();
        $currentTime = time();
        $time = $otpData->setup_time;

        if ($currentTime >= $time && $time >= $currentTime - (90+5) ) {
            return redirect()->back()->with('error' , 'Thử lại sau khoảng 1 phút');
        } else {
            $this->sendOTP($user);
            return redirect()->back()->with('success' , 'Đã gửi lại mã');
        }
    }

    public function forgotPassword() {
        return view('forgotPassword');
    }

    public function handleForgotPassword(Request $request) {

        if ($request->isMethod('POST')) {
            $rules = [
                'password' => 'required|min:6',
                'email' => 'required|email',
                'rePassword' => 'required'
            ];
            $messages = [
                'required' => 'Không được để trống trường này',
                'min' => 'Mật khẩu tối thiểu phải 6 kí tự',
                'same:password' => 'Mật khẩu nhập phải trùng khớp',
            ];
            $request->validate($rules, $messages);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            Session::put('password', $request->password);
            return redirect('/verification/' .$user->id);
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy email');
        }
    }
}
