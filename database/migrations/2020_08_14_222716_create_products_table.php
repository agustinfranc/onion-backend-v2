<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('subrubro_id');
            $table->unsignedSmallInteger('commerce_id');
            $table->integer('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_dirname')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subrubro_id')
                ->references('id')
                ->on('subrubros')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('commerce_id')
                ->references('id')
                ->on('commerces')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique(['commerce_id', 'code']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
