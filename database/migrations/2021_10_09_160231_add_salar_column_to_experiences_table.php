<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalarColumnToExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            //
            // $table->dropColumn('position');
            $table->double('salary')->default(0);
            $table->integer('salary_grade')->default(0);
            $table->string('status_of_appointment')->nullable(true);
            $table->boolean('govnt_service')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experiences', function (Blueprint $table) {
            //
        });
    }
}
