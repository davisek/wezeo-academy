<?php
namespace AppSlack\Slack\Http\Controllers;

use AppSlack\Slack\Http\Resources\MessageResource;
use AppSlack\Slack\Models\Chat;
use AppSlack\Slack\Models\Message;
use AppUser\User\Services\AuthService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($chat_id) {
        $messages = Message::where('chat_id', $chat_id)
            ->with('user', 'reactions.emoji', 'replies', 'parent', 'files')
            ->get();

        AuthService::getUser()->chats()->findOrFail($chat_id);

        return MessageResource::collection($messages);
    }

    public function store() {
        $user = AuthService::getUser();
        $chat = Chat::findOrFail(input('chat_id'));

        $chat->users()->where('id', $user->id)->firstOrFail();

        $message = new Message([
            'chat_id' => input('chat_id'),
            'user_id' => $user->id,
            'parent_id' => input('parent_id', null),
            'text' => input('text', ''),
        ]);

        $message->save();

        if (request()->hasFile('file')) {
            $message->files()->create(['data' => request()->file('file')]);
        }

        return ['message' => 'Message was successfully sent!'];
    }
}
