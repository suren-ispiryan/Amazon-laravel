<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignController extends Controller
{
    public function register (Request $request)
    {
        if ($request->registerInfo['password'] === $request->registerInfo['confirmation']) {
            $user = User::create([
                'name' => $request->registerInfo['name'],
                'surname' => $request->registerInfo['surname'],
                'email' => $request->registerInfo['email'],
                'password' => Hash::make($request->registerInfo['password'])
            ]);
            if ($user) {
                Auth::login($user);
                return response('success');
            }
        }
        return response('failure');
    }

    public function login (Request $request)
    {
        $email = $request->loginInfo['email'];
        $password =  $request->loginInfo['password'];
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response($token);
        }
        return response('failure');
    }

    public function logOut ()
    {
        return response('success');
    }
}
