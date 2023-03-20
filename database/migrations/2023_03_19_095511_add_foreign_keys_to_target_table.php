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
        Schema::table('target', function (Blueprint $table) {
            $table->foreign(['id'], 'FK_target')->references(['id'])->on('user');
            $table->foreign(['ida'], 'FK_targetType')->references(['ida'])->on('aim_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('target', function (Blueprint $table) {
            $table->dropForeign('FK_target');
            $table->dropForeign('FK_targetType');
        });
    }
};
