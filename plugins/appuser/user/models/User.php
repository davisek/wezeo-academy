<?php namespace AppUser\User\Models;

use AppLogger\Logger\Models\Log;
use Model;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appuser_user_users';

    protected $fillable = [
        'username', 'password', 'token'
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    public function logs() {
        return $this->hasMany(Log::class);
    }

}
