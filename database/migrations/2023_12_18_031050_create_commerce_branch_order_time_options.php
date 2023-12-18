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
        Schema::create('commerce_branch_order_time_options', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('commerce_branch_id');

            $table->string('name', 100);
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('takeaway')->default(true);
            $table->boolean('disabled')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('commerce_branch_id')
                ->references('id')
                ->on('commerce_branches')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index(
                ['commerce_branch_id', 'takeaway', 'disabled', 'deleted_at'],
                'commerce_branch_order_time_options_commerce_branch_id_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commerce_branch_order_time_options');
    }
};
