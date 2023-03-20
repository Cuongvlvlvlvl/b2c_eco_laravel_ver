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
        Schema::create('spending', function (Blueprint $table) {
            $table->bigInteger('ids', true);
            $table->date('adddate')->nullable();
            $table->string('desc')->nullable();
            $table->bigInteger('id')->nullable()->index('FK_spending');
            $table->bigInteger('idc')->nullable()->index('FK_spendingType');
            $table->string('name')->nullable();
            $table->double('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spending');
    }
};
