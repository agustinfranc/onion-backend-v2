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
        Schema::create('commerce_branches', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('commerce_id');
            $table->string('name', 100)->unique();
            $table->string('fullname');
            $table->string('address', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->text('maps_account')->nullable();
            $table->string('mp_access_token')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('commerce_id')
                ->references('id')
                ->on('commerces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commerce_branches');
    }
};
