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
        Schema::create('product_options_groupes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('multiple')->default(false);
            $table->boolean('required')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('product_options_groupes');
    }
};
