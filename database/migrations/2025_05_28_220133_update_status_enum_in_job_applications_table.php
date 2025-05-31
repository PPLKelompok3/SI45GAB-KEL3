<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInJobApplicationsTable extends Migration
{
    public function up()
    {
        // Use raw SQL to modify the ENUM
        DB::statement("ALTER TABLE job_applications 
            MODIFY COLUMN status ENUM(
                'Pending', 
                'Processed', 
                'Under_assessment', 
                'Waiting_for_review', 
                'Interview', 
                'Accepted', 
                'Rejected'
            ) NOT NULL DEFAULT 'Pending'");
    }

    public function down()
    {
        // Restore to previous ENUM values (adjust if necessary)
        DB::statement("ALTER TABLE job_applications 
            MODIFY COLUMN status ENUM(
                'Pending', 
                'Processed', 
                'Interview', 
                'Accepted', 
                'Rejected'
            ) NOT NULL DEFAULT 'Pending'");
    }
}