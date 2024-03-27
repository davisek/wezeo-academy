<?php namespace AppSlack\Slack\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('appslack_slack_reactions', function(Blueprint $table) {
            $table->unsignedBigInteger('emoji')->change();
        });
    }

    public function down()
    {
        Schema::table('appslack_slack_reactions', function(Blueprint $table) {
            $table->string('emoji')->change();
        });
    }
};
