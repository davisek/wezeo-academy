<?php namespace AppSlack\Slack\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateChatUsersTable Migration
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
        Schema::create('appslack_slack_chat_users', function(Blueprint $table) {
            $table->unsignedBigInteger('chat_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();

            $table->foreign('chat_id')->references('id')->on('appslack_slack_chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('appuser_user_users')->onDelete('cascade');

            $table->primary(['chat_id', 'user_id']);
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appslack_slack_chat_users');
    }
};
