<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('sales', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->string('service_type', 20);
            $table->string('payment_mode', 20);
            $table->string('reference_number', 30)->nullable();
            $table->decimal('paid', 9, 2)->default(0);
            $table->text('comment')->nullable();
            $table->string('status', 20);
            $table->softDeletes();
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
        //
        Schema::drop('sales');
    }
}
