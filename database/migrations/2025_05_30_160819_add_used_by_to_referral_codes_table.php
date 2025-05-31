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
    Schema::table('referral_codes', function (Blueprint $table) {
        $table->unsignedBigInteger('used_by')->nullable()->after('code');

        // Optional: Add foreign key constraint
        $table->foreign('used_by')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('referral_codes', function (Blueprint $table) {
        $table->dropForeign(['used_by']);
        $table->dropColumn('used_by');
    });
}

};