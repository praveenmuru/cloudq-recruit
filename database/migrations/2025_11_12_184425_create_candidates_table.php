<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();

            $table->string('client')->nullable(); // Client (string)
            $table->date('date_of_joining')->nullable(); // date of joining if joined
            $table->string('title')->nullable(); // candidate title
            $table->json('keywords')->nullable(); // keywords as json array

            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('current_company')->nullable();
            $table->string('current_role')->nullable();

            $table->decimal('total_exp', 5, 2)->nullable(); // years, e.g. 9.50
            $table->decimal('relevant_exp', 5, 2)->nullable();

            $table->decimal('ctc', 8, 2)->nullable()->comment('Current CTC in LPA');
            $table->decimal('ectc', 8, 2)->nullable()->comment('Expected CTC in LPA');

            $table->string('notice_period')->nullable(); // NP
            $table->string('earliest_availability')->nullable(); // text field

            $table->string('location')->nullable();
            $table->string('preferred_location')->nullable();

            $table->enum('work_type', ['Remote', 'Inoffice', 'Hybrid'])->default('Hybrid');

            $table->text('reason_for_job_change')->nullable();
            $table->text('remarks')->nullable();

            $table->string('resume_link')->nullable(); // google drive link

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
