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
            'name' => $request->updateUserData['name'],
            'surname' => $request->updateUserData['surname'],
            'email' => $request->updateUserData['email'],
            'role' => $request->updateUserData['role']
        ]);
        $updatedUser = User::where('id', $id)->first();
        return response()->json($updatedUser);
    }
}
