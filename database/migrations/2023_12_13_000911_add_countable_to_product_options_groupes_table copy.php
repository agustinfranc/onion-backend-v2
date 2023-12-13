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
        Schema::table('product_options_groupes', function (Blueprint $table) {
            $table->boolean('countable')->default(false)->after('required');
            $table->unsignedTinyInteger('min_count')->nullable()->after('countable');
            $table->unsignedTinyInteger('max_count')->nullable()->after('min_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_options_groupes', function (Blueprint $table) {
            $table->dropColumn('countable');
            $table->dropColumn('min_count');
            $table->dropColumn('max_count');
        });
    }
};
