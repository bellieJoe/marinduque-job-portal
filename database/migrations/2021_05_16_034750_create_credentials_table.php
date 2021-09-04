<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credentials', function (Blueprint $table) {
            $table->id('credential_id');
            $table->foreignId('user_id');
            $table->string('credential_type');
            $table->string('credential_name');
            $table->string('credential_number')->nullable();
            $table->string('issuing_organization')->nullable();
            $table->date('date_issued');
            $table->date('expiry_date')->nullable();
            $table->boolean('non_expiry')->nullable();
            $table->string('credential_image')->nullable();
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
        Schema::dropIfExists('credentials');
    }
}
