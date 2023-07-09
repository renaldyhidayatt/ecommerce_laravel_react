<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->store('public/upload/user');
        }

        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->image = $imagePath;
        $user->save();

        return $user;
    }

    public function findAll()
    {
        $users = User::with('role')->select('user_id', 'firstname', 'lastname', 'email', 'image')->get();
        return $users;
    }

    public function findById($id)
    {
        $user = User::with('role')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return $user;
    }

    public function updateById(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::delete($imagePath);
            }
            $imagePath = $request->file('image')->store('public/upload/user');
        }

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->image = $imagePath;
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return $user;
    }

    public function deleteById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->image) {
            Storage::delete($user->image);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
