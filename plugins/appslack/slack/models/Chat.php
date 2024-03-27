<?php namespace AppSlack\Slack\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Chat Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Chat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $fillable = ['name'];

    /**
     * @var string table name
     */
    public $table = 'appslack_slack_chats';

    public $belongsToMany = [
        'users' => [
            User::class,
            'table' => 'appslack_slack_chat_users'
        ]
    ];

    public $hasMany = [
        'messages' => Message::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = ['name' => 'string'];
}
