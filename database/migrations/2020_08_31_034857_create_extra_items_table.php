<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('extra_id');
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->float('price', 8, 2)->nullable();

            $table->foreign('extra_id')
                ->references('id')
                ->on('extras')
                ->onUpdate('cascade')
                ->onDelete('restrict');

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
        Schema::dropIfExists('extra_items');
    }
}
