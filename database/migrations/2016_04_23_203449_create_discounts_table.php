<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('discounts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('type');
            $table->decimal('amount', 9, 2);
            $table->integer('active');
            $table->integer('automatic');
            $table->text('description');
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
        Schema::drop('discounts');
    }
}
