<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmiReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmi_reports', function (Blueprint $table) {
            $table->id("lmi_report_id");
            $table->integer("jobs_solicited_total");
            $table->integer("jobs_solicited_male");
            $table->integer("jobs_solicited_female");
            $table->integer("jobs_solicited_local");
            $table->integer("jobs_solicited_overseas");
            $table->integer("applicants_referred_total");
            $table->integer("applicants_referred_male");
            $table->integer("applicants_referred_female");
            $table->integer("applicants_placed_total");
            $table->integer("applicants_placed_male");
            $table->integer("applicants_placed_female");
            $table->integer("year");
            $table->integer("month");
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
        Schema::dropIfExists('lmi_reports');
    }
}
