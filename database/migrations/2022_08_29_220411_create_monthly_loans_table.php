<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_loans', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->nullable();
            $table->string('glcode')->nullable();
            $table->string('principal')->nullable();
            $table->string('interest_amount')->nullable();
            $table->string('monthly_deduction')->nullable();
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
        Schema::dropIfExists('monthly_loans');
    }
}
