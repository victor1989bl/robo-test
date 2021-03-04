<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('payer_user_id')
                ->unsigned();
            $table->foreign('payer_user_id')
                ->references('id')->on('users');

            $table->integer('recipient_user_id')
                ->unsigned();
            $table->foreign('recipient_user_id')
                ->references('id')->on('users');

            $table->integer('cash')
                ->nullable(false);

            $table->timestampTz('time_to_pay');

            $table->char('status', 10)
                ->nullable(false);
            $table->timestampTz('status_date')
                ->useCurrent();
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
}
