<?php
namespace AppSlack\Slack\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array{
        $reactions = $this->mapReactions($this->reactions);
        $files = $this->mapFiles($this->files);

        $replies = $this->mapReplies($this->replies);
        if ($this->parent_id != null && $replies->isEmpty()) {
            return [];
        }
        return [
            "id" => $this->id,
            "username" => $this->user->username,
            "text" => $this->text,
            "parent_id" => $this->parent_id,
            "reactions" => $reactions,
            "replies" => $replies,
            "files" => $files,
        ];
    }

    private function mapReactions($reactions) {
        return $reactions->map(function ($reaction) {
            return [
                'emoji' => $reaction->emoji->character,
                'username' => $reaction->user->username,
            ];
        });
    }

    private function mapFiles($files) {
        return $files->map(function ($file) {
            return [
                'url' => $file->getPath(),
                'name' => $file->file_name,
            ];
        });
    }

    private function mapReplies($replies) {
        return $replies->map(function ($reply) {
            return [
                'id' => $reply->id,
                'text' => $reply->text,
                'username' => $reply->user->username,
                'reactions' => $this->mapReactions($reply->reactions),
                'files' => $this->mapFiles($reply->files),
            ];
        });
    }
}
