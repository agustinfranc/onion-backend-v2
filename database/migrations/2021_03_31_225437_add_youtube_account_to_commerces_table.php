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
            $table->text('maps_account')->nullable()->after('tiktok_account');
            $table->string('facebook_account', 30)->nullable()->after('instagram_account');
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
            $table->dropColumn('maps_account');
            $table->dropColumn('facebook_account');
        });
    }
}
