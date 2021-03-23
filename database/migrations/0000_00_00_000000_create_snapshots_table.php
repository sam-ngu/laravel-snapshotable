<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnapshotTable extends Migration
{
    public function up()
    {
        Schema::create('__snapshots', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('snapshotable_type');
            $table->foreignId('snapshotable_id');
            $table->json('payload')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('__snapshots');
    }
}
