<?php namespace AppLogger\Logger\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateLogsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('applogger_logger_logs', function(Blueprint $table) {
            $table->id();
            $table->dateTime('datum_prichodu');
            $table->unsignedBigInteger('user_id');
            $table->double('meskanie')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('appuser_user_users')->onDelete('cascade');
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('applogger_logger_logs');
    }
};
