<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => md5($data['password']),
        ]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $input = $request->all();
        //$input = ['email'=>'admin@gmail.com', 'password'=>'Test123$$', 'remember'=>null];

        $user = User::whereRaw('Email = ? and Password = ?',[$input['email'], md5($input['password'])])->first();
        if ($user == null)
            return view('auth.login')->withErrors(['Invalid login or password']);

        Auth::login($user, isset($input['remember']));
        Session::put('login.time',Carbon::now());
        return redirect()->intended('/');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function getTest()
    {
        $q = Session::get('q');
        dds(Session::get('q',0));
        $q++;
        Session::put('q',$q);
        dds(Session::all());
    }

    public function getForgot()
    {
        return view('auth.forgot');
    }

    private function generatePassword()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'0123456789');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
        return $rand;
    }

    public function postForgot(Request $request)
    {
        $messages = [];
        $input = $request->all();

        $isEmail = $input['email'] != '';
        $isCode = isset($input['code']) && $input['code'] != '';

        if (!$isEmail && !$isCode){
            $messages[] = 'Email is empty. Please enter secure code.';
            return view('auth.forgot')->withErrors($messages);
        }

        if ($isCode) {
            $user = User::where(['code'=>$input['code']])->first();
            if ($user == null){
                $messages[] = 'That security code is not valid. Please, enter another security code';
            } else {
                return view('auth.forgot',['email'=>$user->Email]);
            }
        }

        if ($isEmail && !isset($user)){
            $user = User::where(['Email'=>$input['email']])->first();
            if ($user == null){
                $messages[] = 'That email is not valid. Please, enter another email.';
            }
        }

        if ($user == null) {
            return view('auth.forgot')->withErrors($messages);
        }

        $newPassword = $this->generatePassword();
        $user->Password = md5($newPassword);

        $subject="ScoreBook. Reset Password";
        $from = 'support@'.$request->root();
        $fromName = 'Northwood League Support';
        $message="You have successfully reset your password.<br/>Your username: <b>".$user->Email."</b><br/>Your password: <b>$newPassword</b>";

        if ($user->save()){
            $fromName='=?UTF-8?B?'.base64_encode($fromName).'?=';
            $subject='=?UTF-8?B?'.base64_encode($subject).'?=';
            $headers="From: $fromName <{$from}>\r\n".
                "MIME-Version: 1.0\r\n".
                "Content-type: text/html; charset=UTF-8";

            mail($user->Email,$subject,$message,$headers);
            return view('auth.forgot', ['success'=>true]);
        }

        return view('auth.forgot')->withErrors(['Internal error with user']);
    }
}
