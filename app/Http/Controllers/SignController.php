<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
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

                $ids = $request->guestCardProducts;
//            if ($user && $ids) {
                foreach ($ids as $id) {
                    Cart::create([
                        'user_id' => auth()->user()->id,
                        'product_id' => (int)$id['id'],
                        'product_count' => (int)$id['count'],
                    ]);
                }
//            }
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
