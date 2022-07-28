<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->enum('type', [
                'education',
                'training',
                'certification',
                'experience',
                'affiliation',
                'project',
                'soft_skill',
                'tech_skill'
            ])->index();

            $table->text('description')->nullable();

            $table->enum('level', [
                'beginner',
                'advanced',
                'competent',
                'proficient',
                'expert'
            ])->index()->nullable();

            $table->boolean('starred')->index()->nullable();
            $table->dateTime('start_date')->index()->nullable();
            $table->dateTime('end_date')->nullable();
            $table->jsonb('metadata')->nullable();

            $table->foreignId('user_id')
                ->index()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('asset_id')
                ->index()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['user_id', 'asset_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
