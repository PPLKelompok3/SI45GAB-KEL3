<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('under_assessment', 'pending', 'processed', 'interview', 'accepted', 'rejected') NOT NULL");
    }

    public function down()
    {
        // Rollback to previous ENUM values if needed
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending', 'processed', 'interview', 'accepted', 'rejected') NOT NULL");
    }
};