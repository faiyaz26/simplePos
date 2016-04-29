<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('sales_items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->decimal('cost_price',9, 2);
            $table->decimal('selling_price',9, 2);
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

        Schema::drop('sales_items');
    }
}
