<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code',90);
            $table->string('name',90);
            $table->string('category', 90);
            $table->text('description');
           // $table->string('avatar', 255)->default('no-foto.png');
            $table->decimal('cost_price',9, 2);
            $table->decimal('selling_price',9, 2);
            //$table->integer('type')->default(1);
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

        Schema::drop('items');
    }
}
