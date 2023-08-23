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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('Cilent_fk_id');
            $table->string('job_description');
            // $table->string('service_name');
            // $table->enum('currency',['USD', 'GBP','INR','CAD','EURO','AED','SAR'])->default('INR');
            // $table->double('amount');
            $table->string('remarks')->nullable();
            $table->string('payment_date');
            $table->string('invoice_date');
            $table->string('created_by');
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
        Schema::dropIfExists('payments');
    }
};
