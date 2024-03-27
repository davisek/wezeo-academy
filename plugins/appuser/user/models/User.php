<?php namespace AppUser\User\Models;

use AppLogger\Logger\Models\Log;
use AppSlack\Slack\Models\Chat;
use AppSlack\Slack\Models\Message;
use Model;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Hashable;
    use \October\Rain\Database\Traits\Purgeable;

    protected $hashable = ['password'];

    protected $purgeable = ['password_confirmation'];

    protected $fillable = [
        'username', 'password', 'token'
    ];

    public $hasMany = [
        'logs' => Log::class,
        'messages' => Message::class
    ];

    public $belongsToMany = [
        'chats' => [
            Chat::class,
            'table' => 'appslack_slack_chat_users'
        ]
    ];

    /**
     * @var string table name
     */
    public $table = 'appuser_user_users';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'username' => 'required|string|unique:appuser_user_users,username',
        'password' => 'string|min:8'
    ];
}
