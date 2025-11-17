<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Client;
use App\Models\Candidate;
use App\Models\Interview;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            // Add new foreign key fields
            $table->unsignedBigInteger('client_id')->nullable()->after('id');
            $table->unsignedBigInteger('candidate_id')->nullable()->after('client_id');
        });

        // ====== Migrate old data to new fields ======
        $interviews = Interview::all();
        foreach ($interviews as $interview) {

            // Match client name to clients table
            $client = Client::where('name', $interview->client_name)->first();
            if ($client) {
                $interview->client_id = $client->id;
            }

            // Match candidate name to candidates table
            $candidate = Candidate::where('name', $interview->candidate_name)->first();
            if ($candidate) {
                $interview->candidate_id = $candidate->id;
            }

            $interview->save();
        }

        // ====== Now delete old fields ======
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('client_name');
            $table->dropColumn('candidate_name');

            // Add FK constraints
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            // Remove foreign keys
            $table->dropForeign(['client_id']);
            $table->dropForeign(['candidate_id']);

            // Remove new columns
            $table->dropColumn('client_id');
            $table->dropColumn('candidate_id');

            // Add back old fields
            $table->string('client_name')->nullable();
            $table->string('candidate_name')->nullable();
        });
    }
};
