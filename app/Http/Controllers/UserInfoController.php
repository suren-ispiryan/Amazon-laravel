<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateAddressRequest;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    public function createAddress (CreateAddressRequest $request)
    {
        $address = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'number' => $request->number,
            'country' => $request->country,
            'city' => $request->city,
            'street' => $request->street,
            'zip' => $request->zip,
            'default' => false,
        ];

        $address = Address::create($address);

        if ($address) {
            $userData = Address::with('users')
                               ->where('number', $request->number)
                               ->first();
            return response()->json($userData);
        } else {
            return response()->json('failure');
        }
    }

    public function getUserInfo ()
    {
        $user_info = Address::with('users')
                            ->where('user_id', auth()->user()->id)
                            ->get();
        return response()->json($user_info);
    }

    public function makeAddressDefault (Request $request)
    {
        Address::where('id', $request->id)->update([
           'default' => true
        ]);
        Address::where('id', '<>', $request->id)
               ->where('user_id', auth()->user()->id)
               ->update(['default' => false]);
        $updated_address = Address::where('id', $request->id)->first();
        return response()->json($updated_address );
    }

    public function deleteAddress (Request $request)
    {
        Address::where('id', $request->id)->delete();
        return response()->json($request->id);
    }

    public function changePassword (Request $request)
    {
        $old_password = $request->oldPassword;
        $new_password = $request->newPassword;
        $repeat_new_password = $request->repeatNewPassword;

        if (Hash::check($old_password, auth()->user()->password)) {
            if ($new_password === $repeat_new_password) {
                User::where('id', auth()->user()->id)->update([
                   'password' =>  Hash::make($new_password)
                ]);
                return response()->json('Password was successfully changed');
            }
        } else {
            return response()->json('Something went wrong');
        }
    }
}
