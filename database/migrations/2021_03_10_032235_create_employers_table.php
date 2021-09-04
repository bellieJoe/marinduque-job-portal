<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->foreignId('user_id')->unique();
            $table->string('company_name');
            $table->string('description', 5000)->nullable();
            $table->string('mission', 5000)->nullable();
            $table->string('vision', 5000)->nullable();
            $table->json('address')->nullable();
            $table->string('contact_number');
            $table->string('contact_person_name');
            $table->string('company_logo')->nullable();
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
        Schema::dropIfExists('employers');
    }
}
