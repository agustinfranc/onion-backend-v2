<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappNumberToCommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->string('whatsapp_number', 20)->nullable()->after('avatar_dirname');
            $table->string('instagram_account', 30)->nullable()->after('whatsapp_number');
            $table->boolean('has_action_buttons')->default(false)->after('instagram_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->dropColumn('whatsapp_number');
            $table->dropColumn('instagram_account');
            $table->dropColumn('has_action_buttons');
        });
    }
}
