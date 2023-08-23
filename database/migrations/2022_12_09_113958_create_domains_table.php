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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_fk_id');
            $table->string('expiry_date');
            $table->string('registration_date');
            $table->string('domain_name');
            $table->text('registrar_details')->nullable();
            $table->enum('currency',['USD', 'GBP','INR','CAD','EURO','AED','SAR'])->default('INR');
            $table->string('amount')->nullable();
            $table->enum('status',['active' , 'expired' , 'deleted'])->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('domains');
    }
};
