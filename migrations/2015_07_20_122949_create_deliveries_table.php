<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('deliverable_id');
            $table->string('deliverable_type', 255);
            $table->unsignedInteger('user_id', 36)->index();
            $table->unsignedTinyInteger('priority')->index();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deliverable');
    }
}
