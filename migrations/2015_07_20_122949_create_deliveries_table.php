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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('deliverable_id');
            $table->string('deliverable_type', 255);
            $table->unsignedInteger('user_id')->index();
            $table->unsignedTinyInteger('priority')->index();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->unique(['deliverable_id', 'deliverable_type', 'user_id'], 'deliverable_delivery_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deliveries');
    }
}
