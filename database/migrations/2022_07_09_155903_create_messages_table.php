<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender', 100);
            $table->string('email', 50);
            $table->text('body');
            $table->enum('type', [
                'inbox',
                'archives',
                'spam'
            ])->index()->default('inbox');

            $table->foreignId('user_id')
                ->index()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamp('created_at')->index()->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
