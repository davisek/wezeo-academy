<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Http\Requests\StoreUserRequest;
use AppUser\User\Http\Resources\UserResource;
use AppUser\User\Models\User;
use AppUser\User\Services\AuthService;
use Illuminate\Routing\Controller;
use BackendMenu;
use Illuminate\Http\Request;

class UsersController extends Controller {

    public function index() {
        return  User::where('id', '!=', AuthService::getUser()->id)->get();
    }

    public function store(StoreUserRequest  $request) {
        $data = $request->validated();
        $user = User::create($data);
        return new UserResource($user);
    }

    public function changePassword(Request $request) {
        $user = AuthService::getUser();
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user->password = $request->input('password');
        $user->save();

        return ['message' => 'Password was successfully changed.'];
    }
}
