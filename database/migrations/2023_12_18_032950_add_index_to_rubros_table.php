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
        Schema::table('rubros', function (Blueprint $table) {
            $table->index(['deleted_at']);
            $table->index(['id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rubros', function (Blueprint $table) {
            $table->dropIndex('rubros_deleted_at_index');
            $table->dropIndex('rubros_id_deleted_at_index');
        });
    }
};
