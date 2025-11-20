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
    Schema::table('interviews', function (Blueprint $table) {
        $table->unsignedBigInteger('cv_status_id')->nullable()->after('candidate_id');
        $table->unsignedBigInteger('interview_status_id')->nullable()->after('cv_status_id');
        $table->unsignedBigInteger('offer_status_id')->nullable()->after('interview_status_id');

        $table->foreign('cv_status_id')->references('id')->on('cv_statuses')->onDelete('set null');
        $table->foreign('interview_status_id')->references('id')->on('interview_statuses')->onDelete('set null');
        $table->foreign('offer_status_id')->references('id')->on('offer_statuses')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
