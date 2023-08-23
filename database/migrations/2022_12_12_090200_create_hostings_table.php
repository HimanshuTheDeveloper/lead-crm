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
        Schema::create('hostings', function (Blueprint $table) {
            $table->id();
            $table->string('expiry_date');
            $table->string('registration_date');
            $table->unsignedBigInteger('domain_fk_id');
            $table->string('server_data')->nullable();
            $table->unsignedBigInteger('client_fk_id');
            $table->string('amount');
            $table->enum('status',['active' , 'expired' , 'deleted'])->nullable();
            $table->text('comment');
            $table->foreign('domain_fk_id')->references('id')->on('domains')->onDelete('cascade');
            $table->foreign('client_fk_id')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('hostings');
    }
};
