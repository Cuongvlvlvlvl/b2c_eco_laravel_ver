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
        Schema::table('spending', function (Blueprint $table) {
            $table->foreign(['id'], 'FK_spending')->references(['id'])->on('user');
            $table->foreign(['idc'], 'FK_spendingType')->references(['idc'])->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spending', function (Blueprint $table) {
            $table->dropForeign('FK_spending');
            $table->dropForeign('FK_spendingType');
        });
    }
};
