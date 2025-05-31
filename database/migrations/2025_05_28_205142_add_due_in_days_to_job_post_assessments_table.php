<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('job_post_assessments', function (Blueprint $table) {
        $table->dropColumn('due_date');
        $table->unsignedInteger('due_in_days')->nullable(); // e.g. 3 days after applying
    });
}

public function down()
{
    Schema::table('job_post_assessments', function (Blueprint $table) {
        $table->dropColumn('due_in_days');
        $table->date('due_date')->nullable();
    });
}

};