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
        // Link to roles
        $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');

        // Keep old role field as fallback
        $table->string('role')->nullable()->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_requests', function (Blueprint $table) {
            //
        });
    }
};
