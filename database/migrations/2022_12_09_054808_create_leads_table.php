<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_number');
            $table->dateTime('lead_date');
            $table->dateTime('followup_date');
            $table->text('work_description');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alt_mobile')->nullable();
            $table->string('skype')->nullable();
            $table->string('followed')->nullable();
            $table->string('services')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('domain_name')->nullable();
            $table->string('status');
            $table->string('reject_reason')->nullable();
            $table->text('comment')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
