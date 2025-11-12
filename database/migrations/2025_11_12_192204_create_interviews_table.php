<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('role');
            $table->string('candidate_name');
            $table->enum('cv_status', ['Shortlisted', 'Rejected', 'Pending'])->default('Pending');
            $table->date('interview_date')->nullable();
            $table->time('interview_time')->nullable();
            $table->string('client_round')->nullable();
            $table->enum('interview_status', ['Selected', 'Rejected', 'Pending'])->default('Pending');
            $table->enum('offer_status', ['Offered', 'Not Offered'])->default('Not Offered');
            $table->decimal('offered_salary', 8, 2)->nullable(); // in LPA
            $table->date('joining_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('interviews');
    }
};
