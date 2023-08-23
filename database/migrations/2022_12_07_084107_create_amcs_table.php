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
        Schema::create('amcs', function (Blueprint $table) {
            $table->id();
            $table->string('amc_id');
            $table->unsignedBigInteger('client_fk_id');
            $table->foreign('client_fk_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('domain_name');
            $table->string('amc_start_date');
            $table->string('amc_end_date');
            $table->unsignedBigInteger('currency');
            $table->foreign('currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->string('amount');
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
        Schema::dropIfExists('amcs');
    }
};
