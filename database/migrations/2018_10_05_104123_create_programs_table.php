<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('level');
            $table->date('start_date')->default(Carbon::now());
            $table->integer('duration')->default(52);
            $table->boolean('canceled')->default(false);
            $table->boolean('finished')->default(false);
            $table->boolean('paused')->default(false);
            $table->date('paused_date')->nullable();
            $table->date('continue_date')->nullable();
            $table->date('end_date');
            $table->date('new_end_date')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('programs');
    }
}
