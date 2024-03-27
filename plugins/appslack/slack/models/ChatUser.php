<?php namespace AppSlack\Slack\Models;

use Model;

/**
 * ChatUser Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class ChatUser extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $fillable = ['chat_id', 'user_id'];

    /**
     * @var string table name
     */
    public $table = 'appslack_slack_chat_users';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'chat_id' => 'numeric|required',
        'user_id' => 'numeric|required'
    ];
}
