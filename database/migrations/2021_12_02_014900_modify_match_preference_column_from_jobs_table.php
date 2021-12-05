<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMatchPreferenceColumnFromJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('jobs', function (Blueprint $table) {
            //
            $preference = ["educational_attainment" => 30, "skills" => 40,"yoe" => 30 ];
            $table->dropColumn(['match_preference']);
            $table->json('match_preferences')->default(json_encode($preference));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
