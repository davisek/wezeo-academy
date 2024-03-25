<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Http\Requests\StoreUserRequest;
use AppUser\User\Http\Resources\UserResource;
use AppUser\User\Models\User;
use Illuminate\Routing\Controller;
use BackendMenu;
use Illuminate\Http\Request;

class UsersController extends Controller {
    public function store(StoreUserRequest  $request) {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        return response(new UserResource($user), 201);
    }

    public function changePassword(Request $request, $id) {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json(['message' => 'Password was successfully changed.']);
    }
}
