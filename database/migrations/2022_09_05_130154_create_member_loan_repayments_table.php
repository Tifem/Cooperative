<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLoanRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->string('transactiondate')->nullable();
            $table->string('member_name')->nullable();
            $table->string('loan_name')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('bank')->nullable();
            $table->string('teller_number')->nullable();
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
        Schema::dropIfExists('member_loan_repayments');
    }
}
