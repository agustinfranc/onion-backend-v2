<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCurrencyToNameFromCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->renameColumn('currency', 'name');
            $table->renameColumn('currency_code', 'code');
            $table->renameColumn('currency_symbol', 'symbol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->renameColumn('name', 'currency');
            $table->renameColumn('code', 'currency_code');
            $table->renameColumn('symbol', 'currency_symbol');
        });
    }
}
