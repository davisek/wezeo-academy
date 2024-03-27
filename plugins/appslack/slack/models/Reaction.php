<?php namespace AppSlack\Slack\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Reaction Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Reaction extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $fillable = ['user_id', 'message_id', 'emoji_id'];

    /**
     * @var string table name
     */
    public $table = 'appslack_slack_reactions';

    public $belongsTo = [
        'message' => Message::class,
        'user' => User::class,
        'emoji' => Emoji::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
