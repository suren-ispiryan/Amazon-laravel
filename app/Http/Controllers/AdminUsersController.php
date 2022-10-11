<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AdminUpdateUserRequest;

class AdminUsersController extends Controller
{
    public function getUserList ()
    {
        try {
            $user_list = User::get();
            return response()->json($user_list);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            User::where('id', $id)->delete();
            return response()->json($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
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

        $updated_user = User::where('id', $id)->first();
        return response()->json($updated_user);
    }
}
