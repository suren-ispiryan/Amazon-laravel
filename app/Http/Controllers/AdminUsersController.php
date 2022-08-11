<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AdminUpdateUserRequest;

class AdminUsersController extends Controller
{
    public function getUserList ()
    {
        $userList = User::get();
        return response()->json($userList);
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return response()->json($id);
    }

    public function updateUser(AdminUpdateUserRequest $request)
    {
        $id = $request->id;
        User::where('id', $id)->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'role' => $request->role
        ]);

        $email = User::where('email', $request->email)->first();
        if (!$email) {
            User::where('id', $id)->update([
                'email' => $request->email
            ]);
        }

        $updatedUser = User::where('id', $id)->first();
        return response()->json($updatedUser);
    }
}
