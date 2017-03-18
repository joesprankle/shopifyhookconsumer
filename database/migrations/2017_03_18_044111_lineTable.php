<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopifyfulfillment', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->date('order_created_at');
            $table->integer('product_id')->unsigned();
            $table->string('title', 50)->nullable();
            $table->integer('quantity')->unsigned();
            $table->float('price');
            $table->integer('fulfillable_quantity')->unsigned();
            $table->timestamps();
        });
      //  order_id,created_at, line_items:product_id, line_items:title, line_items:quantity, line_items:price, line_items:fulfillable_quantity
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
