<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_song', function (Blueprint $table) {
            $table->foreignId('artist_id');
            $table->foreignId('song_id');
            $table->foreign('artist_id')->references('id')->on('artists')
                ->onDelete('cascade');
            $table->foreign('song_id')->references('id')->on('songs')
                ->onDelete('cascade');
        });

        Schema::create('song_tag', function (Blueprint $table) {
            $table->foreignId('song_id');
            $table->foreignId('tag_id');
            $table->foreign('song_id')->references('id')->on('songs')
                ->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade');
        });

        Schema::create('sheet_user', function (Blueprint $table) {
            $table->foreignId('sheet_id');
            $table->foreignId('user_id');
            $table->foreign('sheet_id')->references('id')->on('sheets')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song_artist');
        Schema::dropIfExists('song_tag');
        Schema::dropIfExists('user_sheet');
    }
}
