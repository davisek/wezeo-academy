<?php
namespace AppSlack\Slack\Http\Controllers;

use AppSlack\Slack\Http\Resources\ChatResource;
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

        return $chatsData;
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
        return [
            'message' => 'Chat created successfully.',
            new ChatResource($chat)
        ];
    }

    public function update(Request $request) {
        $user = AuthService::getUser();
        $data['name'] = $request->input('name');
        $data['id'] = $request->input('id');

        $currentChat = Chat::find($data['id']);
        if (!$currentChat) {
            return response(['message' => 'Chat not found.'], 404);
        }

        $isUserInChat = $currentChat->users()->where('id', $user->id)->exists();
        if (!$isUserInChat) {
            return response(['message' => 'You are not a participant in this chat.'], 403);
        }

        $currentChat->name = $data['name'];
        $currentChat->save();
        return [
            'message' => 'Chat updated successfully.',
            new ChatResource($currentChat)
        ];
    }
}
