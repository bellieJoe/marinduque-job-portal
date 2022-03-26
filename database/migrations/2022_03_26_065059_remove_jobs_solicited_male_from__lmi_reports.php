<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveJobsSolicitedMaleFromLmiReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lmi_reports', function (Blueprint $table) {
            $table->dropColumn(['jobs_solicited_male', 'jobs_solicited_female']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_lmi_reports', function (Blueprint $table) {
            //
        });
    }
}
