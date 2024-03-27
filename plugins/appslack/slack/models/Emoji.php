<?php namespace AppSlack\Slack\Models;

use Model;

/**
 * Emoji Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Emoji extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $fillable = ['character', 'description'];

    /**
     * @var string table name
     */
    public $table = 'appslack_slack_emoji';

    public $hasMany = [
        'reactions' => Reaction::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'character' => 'required'
    ];
}
