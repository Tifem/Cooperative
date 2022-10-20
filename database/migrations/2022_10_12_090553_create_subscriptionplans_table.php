<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptionplans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name')->nullable();
            $table->string('plan_amount')->nullable();
            $table->integer('member_no')->nullable();
            $table->integer('savings_no')->nullable();
            $table->integer('loan_no')->nullable();
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
        Schema::dropIfExists('subscriptionplans');
    }
}
