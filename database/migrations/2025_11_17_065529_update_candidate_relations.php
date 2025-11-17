<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Remove old keywords JSON if present
            if (Schema::hasColumn('candidates', 'keywords')) {
                $table->dropColumn('keywords');
            }

            // Add foreign key for single location
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
        });

        // Pivot table for candidate <-> skills
        Schema::create('candidate_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
        });

        // Pivot table for candidate <-> preferred_locations
        Schema::create('candidate_preferred_location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidate_skill');
        Schema::dropIfExists('candidate_preferred_location');

        Schema::table('candidates', function (Blueprint $table) {
            $table->dropConstrainedForeignId('location_id');
            $table->json('keywords')->nullable(); // rollback compatibility
        });
    }
};
