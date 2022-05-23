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
            $table->boolean('mp_enabled')->default(false)->after('mp_access_token');
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
            $table->dropColumn('mp_enabled');
        });
    }
};
