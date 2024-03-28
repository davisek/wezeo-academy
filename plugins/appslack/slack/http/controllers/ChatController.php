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

        $chats = $user->chats()->get();
        return ChatResource::collection($chats);
    }

    public function store(Request $request) {
        $currentUser = AuthService::getUser();
        $user_id = $request->input('user_id');
        $withUser = User::where('id', $user_id)->firstOrFail();

        $currentUserChats = $currentUser->chats()->pluck('id');
        $isThereChatAlready = $withUser->chats()->whereIn('id', $currentUserChats)->first();

        if ($isThereChatAlready) {
            return new ChatResource($isThereChatAlready);
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

        $currentChat = Chat::where('id', $data['id'])->firstOrFail();

        $currentChat->users()->where('id', $user->id)->firstOrFail();

        $currentChat->name = $data['name'];
        $currentChat->save();
        return [
            'message' => 'Chat updated successfully.',
            new ChatResource($currentChat)
        ];
    }
}
