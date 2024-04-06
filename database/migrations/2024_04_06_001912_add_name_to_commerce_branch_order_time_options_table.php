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
        Schema::table('commerce_branch_order_time_options', function (Blueprint $table) {
            $table->string('name', 100)->nullable()->after('commerce_branch_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commerce_branch_order_time_options', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
