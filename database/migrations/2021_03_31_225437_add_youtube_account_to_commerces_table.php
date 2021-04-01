<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYoutubeAccountToCommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->string('youtube_account', 30)->nullable()->after('instagram_account');
            $table->string('tiktok_account', 30)->nullable()->after('youtube_account');
            $table->string('address', 50)->nullable()->after('fullname');
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
            $table->dropColumn('youtube_account');
            $table->dropColumn('tiktok_account');
            $table->dropColumn('address');
        });
    }
}
