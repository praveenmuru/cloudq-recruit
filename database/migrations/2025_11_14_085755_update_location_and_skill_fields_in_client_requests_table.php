<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('client_requests', function (Blueprint $table) {
            // Change to LONGTEXT
            $table->longText('skills_sets')->nullable()->change();
            $table->longText('location')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('client_requests', function (Blueprint $table) {
            // Revert back to TEXT or STRING depending on what it was before
            $table->text('skills_sets')->nullable()->change();
            $table->string('location')->nullable()->change();
        });
    }
};
