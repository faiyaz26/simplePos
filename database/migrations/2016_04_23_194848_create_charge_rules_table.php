<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargeRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('charge_rules', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('type');
            $table->decimal('amount', 9, 2);
            $table->boolean('active')->default(0);
            $table->text('description');
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

        Schema::drop('charge_rules');
    }
}
