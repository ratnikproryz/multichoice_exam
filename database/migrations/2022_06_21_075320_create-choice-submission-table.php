<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choice_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('choice_id');
            $table->unsignedInteger('submission_id');
            $table->foreign('choice_id')
                ->references('id')
                ->on('choices')
                ->onDelete('cascade');
            $table->foreign('submission_id')
                ->references('id')
                ->on('submissions')
                ->onDelete('cascade');
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
        Schema::dropIfExists('choice_submissions');
    }
};
