<?php

namespace App\Http\Controllers;
use App\Mail\User\VerifyMail;
use App\Models\User;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Mail;

class SignController extends Controller
{
    public function register (RegisterRequest $request)
    {
        if ($request->registerInfo['password'] === $request->registerInfo['confirmation']) {
            $str = rand();
            $token = md5($str);
            $user = User::create([
                'name' => $request->registerInfo['name'],
                'surname' => $request->registerInfo['surname'],
                'email' => $request->registerInfo['email'],
                'password' => Hash::make($request->registerInfo['password']),
                'token' => $token
            ]);
            if ($user) {
                Auth::login($user);
                Mail::to($request->registerInfo['email'])->send(new VerifyMail($token));

                $ids = $request->guestCardProducts;
                if ($ids) {
                    foreach ($ids as $id) {
                        Cart::create([
                            'user_id' => auth()->user()->id,
                            'product_id' => (int)$id['id'],
                            'product_count' => (int)$id['count'],
                        ]);
                    }
                }
                return response('success');
            }
        }
        return response('failure');
    }

    public function login (LoginRequest $request)
    {
        $email = $request->email;
        $password =  $request->password;
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        $superAdminCheck = User::where('email', $email)->first();
        if ($superAdminCheck->role === 'user' && $superAdminCheck->email_verified_at !== null) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('token')->plainTextToken;
                return response($token);
            }
        }
    }

    public function adminLogin (AdminLoginRequest $request)
    {
        $email = $request->loginAdminInfo['email'];
        $password =  $request->loginAdminInfo['password'];
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        $superAdminCheck = User::where('email', $email)->first();
        if ($superAdminCheck->role !== 'user') {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('token')->plainTextToken;
                return response($token);
            }
        }
        return response('failure');
    }

    public function getAuthUserRole ()
    {
        $authUserRole = User::where('id', auth()->user()->id)->first();
        return response()->json($authUserRole->role);
    }

    public function logOut ()
    {
        return response('success');
    }

    public function verify ($token)
    {
        User::where('token', $token)->update(['email_verified_at' => Carbon::now()]);
        return response()->json('successfully verified');
    }
}
