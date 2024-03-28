<?php
namespace AppSlack\Slack\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array{
        return [
            'chat_id' => $this->id,
            'chat_name' => $this->name,
            'participants' => $this->users->map(function ($user) {
                return ['user_id' => $user->id, 'name' => $user->username];
            })
        ];
    }
}
