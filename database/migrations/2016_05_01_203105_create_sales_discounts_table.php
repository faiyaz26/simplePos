<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sales_discounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('discount_id')->unsigned();
            $table->integer('type');
            $table->decimal('amount', 9, 2);
            $table->timestamps();
            $table->softDeletes();
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

        Schema::drop('sales_discounts');
    }
}
