<?php namespace AppSlack\Slack\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMessagesTable Migration
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
        Schema::create('appslack_slack_messages', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('user_id');
            $table->text('text')->nullable();
            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('appslack_slack_chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('appuser_user_users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('appslack_slack_messages')->onDelete('set null');
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appslack_slack_messages');
    }
};
