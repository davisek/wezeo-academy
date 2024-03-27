<?php namespace AppLogger\Logger\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Log Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Log extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $fillable = ['arrival_date', 'user_id', 'delay'];

    public $belongsTo = [
        'user' => User::class
    ];

    /**
     * @var string table name
     */
    public $table = 'applogger_logger_logs';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'arrival_date' => 'required|date',
        'delay' => 'required|numeric',
        'user_id' => 'required'
    ];
}
