<?php namespace AppLogger\Logger\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applogger_logger_logs', function($table)
        {
            $table->renameColumn('datum_prichodu', 'arrival_date');
            $table->renameColumn('meskanie', 'delay');
        });
    }

    public function down()
    {
        Schema::table('applogger_logger_logs', function($table)
        {
            $table->renameColumn('arrival_date', 'datum_prichodu');
            $table->renameColumn('delay', 'meskanie');
        });
    }
};
