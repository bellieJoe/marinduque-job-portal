<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSprsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprs', function (Blueprint $table) {
            $table->id('sprs_id');
            $table->integer('vacancies_solicited');
            $table->integer('applicants_registered');
            $table->integer('applicants_placed_private');
            $table->integer('applicants_placed_government');
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
        Schema::dropIfExists('sprs');
    }
}
