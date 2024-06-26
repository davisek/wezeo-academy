<?php
namespace AppSlack\Slack\Http\Controllers;

use AppSlack\Slack\Http\Resources\ReactionResource;
use AppSlack\Slack\Models\Emoji;
use AppSlack\Slack\Models\Message;
use AppSlack\Slack\Models\Reaction;
use AppUser\User\Services\AuthService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store()
    {
        $currentUser = AuthService::getUser();
        $messageId = input('message_id');
        $emojiId = input('emoji_id');

        $message = Message::findOrFail($messageId);

        $userIsInChat = $message->chat->users()->where('id', $currentUser->id)->exists();
        if (!$userIsInChat) {
            return response(['message' => 'Access denied.'], 403);
        }

        $reaction = Reaction::create([
            'message_id' => $messageId,
            'user_id' => $currentUser->id,
            'emoji_id' => $emojiId
        ]);
        return [
            'message' => 'You replied to a message.',
            new ReactionResource($reaction)
        ];
    }
}
