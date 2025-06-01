<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('company_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned(); // 1–5 stars
            $table->text('comment');
            $table->boolean('is_useful')->default(false); // for PBI-021
            $table->timestamps();
            
            // prevent duplicate reviews per user/company
            $table->unique(['company_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_reviews');
    }
}