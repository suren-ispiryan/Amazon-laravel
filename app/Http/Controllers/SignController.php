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
        if ($request->userData['password'] === $request->userData['confirmation']) {
            $user = User::create([
                'name' => $request->userData['name'],
                'surname' => $request->userData['surname'],
                'email' => $request->userData['email'],
                'password' => Hash::make($request->userData['password'])
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
        $email = $request->userLoginData['email'];
        $password = $request->userLoginData['password'];
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
