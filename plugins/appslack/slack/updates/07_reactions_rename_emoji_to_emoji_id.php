<?php namespace AppSlack\Slack\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('appslack_slack_reactions', function(Blueprint $table) {
            $table->renameColumn('emoji', 'emoji_id');
            $table->foreign('emoji_id')->references('id')->on('appslack_slack_emoji')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('appslack_slack_reactions', function(Blueprint $table) {
            $table->dropForeign(['emoji_id']);

            $table->renameColumn('emoji_id', 'emoji');
        });
    }
};
