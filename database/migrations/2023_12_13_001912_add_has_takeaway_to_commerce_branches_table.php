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
        Schema::table('commerce_branches', function (Blueprint $table) {
            $table->boolean('has_delivery')->default(true)->after('mp_enabled');
            $table->boolean('has_takeaway')->default(false)->after('has_delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commerce_branches', function (Blueprint $table) {
            $table->dropColumn('has_delivery');
            $table->dropColumn('has_takeaway');
        });
    }
};
