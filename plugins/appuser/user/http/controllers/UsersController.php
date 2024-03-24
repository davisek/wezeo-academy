<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Http\Requests\StoreUserRequest;
use AppUser\User\Http\Resources\UserResource;
use AppUser\User\Models\User;
use Illuminate\Routing\Controller;
use BackendMenu;
use Illuminate\Http\Request;

class UsersController extends Controller {


    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct() {
        BackendMenu::setContext('AppUser.User', 'user', 'users');
    }

    // Backend LIST with UPDATE
    public function index() {
        $users = User::all();
        return view('appuser.user::users_list', ['users' => $users]);
    }

    public function update($id, Request $request) {
        $validatedData = $request->validate([
            'password' => 'string|min:8|confirmed',
            'username' => 'required|string|unique:appuser_user_users,username,' . $id,
        ]);
        $user = User::findOrFail($id);

        if(isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);
        return response()->json(['message' => 'Successfully added.']);
    }

    // End of code of Backend LIST

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
