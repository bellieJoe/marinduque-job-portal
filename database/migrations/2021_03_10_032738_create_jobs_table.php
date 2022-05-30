<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id('job_id');
            $table->foreignId('user_id');
            $table->string('job_industry');
            $table->string('job_title');
            $table->string('job_type');
            $table->string('job_description', 5000)->nullable();
            // company information
            $table->string('company_name');
            $table->json('company_address');
            $table->string('company_description', 5000)->nullable();
            // qualifications
            $table->string('educational_attainment')->nullable();
            $table->string('course_studied')->nullable();
            $table->string('gender')->nullable();
            $table->integer('experience')->nullable();
            $table->json('other_qualification')->nullable();
            // miscellaneous
            $table->json('salary_range')->nullable();
            $table->string('job_benefits', 5000)->nullable();

            $table->string('status');
            $table->timestamp('date_posted');
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
        Schema::dropIfExists('jobs');
    }
}
