<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCommentTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_tag', function (Blueprint $table) {
            $table->bigInteger('comment_id')->unsigned()->index();
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('form_tags')->onDelete('cascade');
            $table->string('rating')->nullable();
            $table->primary(['comment_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_tag');
    }
}
