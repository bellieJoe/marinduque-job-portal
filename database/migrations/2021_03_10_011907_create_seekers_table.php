<?php

use Google\CRC32\Table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seekers', function (Blueprint $table) {
            $table->foreignId('user_id')->unique();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('address')->nullable($value = true);
            $table->date('birthdate')->nullable($value = true);
            $table->string('contact_number')->nullable($value = true);
            $table->string('gender')->nullable($value = true);
            $table->string('nationality')->nullable($value = true);
            $table->string('civil_status')->nullable($value = true);
            $table->json('language')->nullable($value = true);
            $table->string('display_picture')->nullable($value = true);
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
        Schema::dropIfExists('seekers');
    }
}
