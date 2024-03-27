<?php
namespace AppSlack\Slack\Http\Controllers;

use AppSlack\Slack\Models\Chat;
use AppSlack\Slack\Models\Message;
use AppUser\User\Services\AuthService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($chat_id) {
        $currentUserId = AuthService::getUser()->id;
        $messages = Message::where('chat_id', $chat_id)
            ->with('user', 'reactions.emoji', 'replies', 'parent')
            ->get();

        $chat = Chat::whereHas('users', function($query) use ($currentUserId) {
            $query->where('id', $currentUserId);
        })->find($chat_id);

        if (!$chat) {
            return response(['message' => 'Chat not found or access denied'], 404);
        }

        $formattedMessages = $messages->map(function ($message) {
            $reactions = $message->reactions->map(function ($reaction) {
                return [
                    'emoji' => $reaction->emoji->character,
                    'username' => $reaction->user->username,
                ];
            });

            $replies = $message->replies->map(function ($reply) {
                return [
                    'id' => $reply->id,
                    'text' => $reply->text,
                    'username' => $reply->user->username,
                ];
            });

            return [
                "id" => $message->id,
                "username" => $message->user->username,
                "text" => $message->text,
                "parent_id" => $message->parent_id,
                "reactions" => $reactions,
                "replies" => $replies,
            ];
        });

        return $formattedMessages;
    }

    public function store(Request $request)
    {
        $currentUserId = AuthService::getUser()->id;

        $chat = Chat::find($request->input('chat_id'));
        if (!$chat) {
            return response(['message' => 'Chat not found'], 404);
        }

        $userIsInChat = $chat->users()->where('id', $currentUserId)->exists();
        if (!$userIsInChat) {
            return response(['message' => 'User is not a member of the chat'], 403);
        }

        $data = $request->only(['text', 'chat_id']);
        $data['user_id'] = $currentUserId;

        // Control if its reply
        if ($request->has('parent_id')) {
            $parentMessage = Message::find($request->input('parent_id'));

            if (!$parentMessage || $parentMessage->chat_id != $chat->id) {
                return response()->json(['message' => 'Parent message not found or does not belong to the same chat'], 404);
            }

            $data['parent_id'] = $request->input('parent_id');
        }

        Message::create($data);
        return response(['message' => 'Message was successfully sent!'], 201);

    }
}
