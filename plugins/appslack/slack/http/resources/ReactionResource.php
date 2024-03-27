<?php
namespace AppSlack\Slack\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'message_id' => $this->message_id,
            'user_id' => $this->user_id,
            'emoji_id' => $this->emoji_id,
            'created_at' => $this->created_at->format('Y-m-D H:i:s')
        ];
    }
}
