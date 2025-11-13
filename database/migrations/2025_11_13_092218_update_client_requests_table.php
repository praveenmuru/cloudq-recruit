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
    Schema::table('client_requests', function (Blueprint $table) {
        // Add client_id column
        $table->foreignId('client_id')
              ->nullable()
              ->after('id')
              ->constrained('clients')
              ->onDelete('set null');

        // Ensure client_name column exists as fallback
        if (!Schema::hasColumn('client_requests', 'client_name')) {
            $table->string('client_name')->nullable()->after('client_id');
        }
    });
}

public function down()
{
    Schema::table('client_requests', function (Blueprint $table) {
        $table->dropForeign(['client_id']);
        $table->dropColumn('client_id');
    });
}
};
