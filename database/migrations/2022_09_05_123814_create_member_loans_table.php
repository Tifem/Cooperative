<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_loans', function (Blueprint $table) {
            $table->id();
            $table->string('member_name')->nullable();
            $table->string('loan_name')->nullable();
            $table->string('principal_amount')->nullable();
            $table->string('interest_amount')->nullable();
            $table->string('total_repayment')->nullable();
            $table->string('duration')->nullable();
            $table->string('monthly_deduction')->nullable();
            $table->string('loan_interest')->nullable();
            $table->string('bank')->nullable();
            $table->string('reciept_number')->nullable();
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
        Schema::dropIfExists('member_loans');
    }
}
