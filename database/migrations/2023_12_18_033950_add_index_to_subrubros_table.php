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
        Schema::table('subrubros', function (Blueprint $table) {
            $table->index(['deleted_at']);
            $table->index(['rubro_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subrubros', function (Blueprint $table) {
            $table->dropIndex('subrubros_deleted_at_index');
            $table->dropIndex('subrubros_rubro_id_deleted_at_index');
        });
    }
};
