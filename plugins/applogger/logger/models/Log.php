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

    protected $fillable = ['datum_prichodu', 'user_id', 'meskanie'];

    /**
     * @var string table name
     */
    public $table = 'applogger_logger_logs';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'datum_prichodu' => 'required|date',
        'meskanie' => 'required|numeric',
        'user_id' => 'required'
    ];

    public function user(): \October\Rain\Database\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
