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
        Schema::create('form_mail_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('form_id');
    $table->string('email');
    $table->string('status')->default('pending'); // pending, success, failed
    $table->text('error')->nullable();
    $table->timestamps();

    $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_mail_logs');
    }
};
