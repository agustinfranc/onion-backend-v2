<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommerceRubroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commerce_rubro', function (Blueprint $table) {
            $table->unsignedSmallInteger('commerce_id');
            $table->unsignedSmallInteger('rubro_id');

            $table->foreign('commerce_id')
                ->references('id')
                ->on('commerces')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('rubro_id')
                ->references('id')
                ->on('rubros')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique(['commerce_id', 'rubro_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commerce_rubro');
    }
}
