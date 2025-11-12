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
    Schema::create('client_requests', function (Blueprint $table) {
        $table->id();
        $table->string('client_name');
        $table->string('point_of_contact')->nullable();
        $table->string('point_of_contact_number')->nullable();
        $table->string('role');
        $table->string('position_status')->nullable();
        $table->text('skills_sets')->nullable();
        $table->string('experience')->nullable();
        $table->string('location')->nullable();
        $table->text('remarks')->nullable();
        $table->string('panel_availability')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_requests');
    }
};
