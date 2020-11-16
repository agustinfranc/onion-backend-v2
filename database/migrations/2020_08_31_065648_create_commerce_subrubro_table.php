<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommerceSubrubroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commerce_subrubro', function (Blueprint $table) {
            $table->unsignedSmallInteger('commerce_id');
            $table->unsignedSmallInteger('subrubro_id');

            $table->foreign('commerce_id')
                ->references('id')
                ->on('commerces')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('subrubro_id')
                ->references('id')
                ->on('subrubros')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique(['commerce_id', 'subrubro_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commerce_subrubro');
    }
}
