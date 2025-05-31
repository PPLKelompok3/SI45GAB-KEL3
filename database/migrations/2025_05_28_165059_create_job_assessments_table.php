<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_post_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['essay', 'file_upload']);
            $table->text('instruction');
            $table->string('attachment')->nullable(); // for file_upload (e.g. PDF)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_post_assessments');
    }
};