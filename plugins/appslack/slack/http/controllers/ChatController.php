<?php
namespace AppSlack\Slack\Http\Controllers;

use AppSlack\Slack\Models\Chat;
use AppUser\User\Models\User;
use AppUser\User\Services\AuthService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index() {
        $user = AuthService::getUser();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $chats = $user->chats()->with('users')->get();

        $chatsData = $chats->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'chat_name' => $chat->name,
                'participants' => $chat->users->map(function ($user) {
                    return ['user_id' => $user->id, 'name' => $user->username];
                })
            ];
        });

        return response()->json($chatsData);
    }

    public function store(Request $request) {
        $currentUser = AuthService::getUser();
        $user_id = $request->input('user_id');
        $withUser = User::where('id', $user_id)->first();
        if (!$withUser) {
            return Response(['message' => 'None of the users have this ID.'], 404);
        }
        $currentUserChats = $currentUser->chats()->pluck('id');
        $commonChat = $withUser->chats()->whereIn('id', $currentUserChats)->first();

        if ($commonChat) {
            return $this->index();
        }

        $chat = new Chat;
        $chat->name = "New Chat";
        $chat->save();
        $chat->users()->attach([$currentUser->id, $withUser->id]);
        return $chat;
    }
}
