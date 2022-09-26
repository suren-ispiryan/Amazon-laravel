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
        $address = Address::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'number' => $request->number,
            'country' => $request->country,
            'city' => $request->city,
            'street' => $request->street,
            'zip' => $request->zip,
            'default' => false,
        ]);
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
        $userInfo = Address::with('users')
                           ->where('user_id', auth()->user()->id)
                           ->get();
        return response()->json($userInfo);
    }

    public function makeAddressDefault (Request $request)
    {
        Address::where('id', $request->id)->update([
           'default' => true
        ]);
        Address::where('id', '<>', $request->id)
               ->where('user_id', auth()->user()->id)
               ->update(['default' => false]);
        $updatedAddress = Address::where('id', $request->id)->first();
        return response()->json($updatedAddress );
    }

    public function deleteAddress (Request $request)
    {
        Address::where('id', $request->id)->delete();
        return response()->json($request->id);
    }

    public function changePassword (Request $request)
    {
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $repeatNewPassword = $request->repeatNewPassword;

        if (Hash::check($oldPassword, auth()->user()->password)) {
            if ($newPassword === $repeatNewPassword) {
                User::where('id', auth()->user()->id)->update([
                   'password' =>  Hash::make($newPassword)
                ]);
                return response()->json('Password was successfully changed');
            }
        } else {
            return response()->json('Something went wrong');
        }
    }
}
