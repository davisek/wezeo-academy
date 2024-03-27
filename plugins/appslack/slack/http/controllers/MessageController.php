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
            ->with('user', 'reactions.emoji', 'replies', 'parent', 'files')
            ->get();

        $chat = Chat::whereHas('users', function($query) use ($currentUserId) {
            $query->where('id', $currentUserId);
        })->find($chat_id);

        if (!$chat) {
            return response(['message' => 'Chat not found or access denied'], 404);
        }

        // Mapovanie dát
        $formattedMessages = $messages->map(function ($message) {
            $reactions = $message->reactions->map(function ($reaction) {
                return [
                    'emoji' => $reaction->emoji->character,
                    'username' => $reaction->user->username,
                ];
            });

            $files = $message->files->map(function ($file) {
                return [
                    'url' => $file->getPath(),
                    'name' => $file->file_name,
                ];
            });
            // Maping of replies if hierarchy is needed
            $replies = $message->replies->map(function ($reply) {
                $replyReactions = $reply->reactions->map(function ($reaction) {
                    return [
                        'emoji' => $reaction->emoji->character,
                        'username' => $reaction->user->username,
                    ];
                });

                $replyFiles = $reply->files->map(function ($file) {
                    return [
                        'url' => $file->getPath(),
                        'name' => $file->file_name,
                    ];
                });

                return [
                    'id' => $reply->id,
                    'text' => $reply->text,
                    'username' => $reply->user->username,
                    'reactions' => $replyReactions,
                    'files' => $replyFiles,
                ];
            });
            // End of mapping replies
            if ($message->parent_id != null && $replies->isEmpty()) {
                return null;
            } else {
                return [
                    "id" => $message->id,
                    "username" => $message->user->username,
                    "text" => $message->text,
                    "parent_id" => $message->parent_id,
                    "reactions" => $reactions,
                    "replies" => $replies,
                    "files" => $files,
                ];
            }
        })->filter();

        return $formattedMessages;
    }

    public function store(Request $request) {
        $currentUserId = AuthService::getUser()->id;
        $chat = Chat::find($request->input('chat_id'));
        if (!$chat) {
            return response(['message' => 'Chat not found'], 404);
        }

        $userIsInChat = $chat->users()->where('id', $currentUserId)->exists();
        if (!$userIsInChat) {
            return response(['message' => 'User is not a member of the chat'], 403);
        }

        // Control if its reply
        if ($request->has('parent_id')) {
            $parentMessage = Message::find($request->input('parent_id'));
            if (!$parentMessage || $parentMessage->chat_id != $chat->id) {
                return response()->json(['message' => 'Parent message not found or does not belong to the same chat'], 404);
            }
        }

        $message = new Message([
            'chat_id' => $request->input('chat_id'),
            'user_id' => $currentUserId,
            'parent_id' => $request->input('parent_id', null),
            'text' => $request->input('text', ''),
        ]);

        $message->save();

        if ($request->hasFile('file')) {
            $message->files()->create(['data' => $request->file('file')]);
        }

        return ['message' => 'Message was successfully sent!'];
    }
}
