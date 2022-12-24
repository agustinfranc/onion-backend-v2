<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_options_groupe_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_options_groupe_id')
                ->references('id')
                ->on('product_options_groupes')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_options');
    }
};
