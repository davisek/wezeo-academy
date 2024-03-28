<?php namespace AppSlack\Slack\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Message Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Message extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $fillable = ['parent_id','chat_id', 'user_id', 'text'];

    /**
     * @var string table name
     */
    public $table = 'appslack_slack_messages';

    public $belongsTo = [
        'chat' => Chat::class,
        'user' => User::class,
        'parent' => [self::class, 'key' => 'parent_id']
    ];

    public $hasMany = [
        'reactions' => Reaction::class,
        'replies' => [self::class, 'key' => 'parent_id']
    ];

    public $attachMany = [
        'files' => ['System\Models\File']
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'parent_id' => 'nullable|numeric',
        'chat_id' => 'numeric|required',
        'user_id' => 'numeric|required',
        'text' => 'string',
    ];
}
