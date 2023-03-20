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
        Schema::create('dept', function (Blueprint $table) {
            $table->bigInteger('idd', true);
            $table->date('adddate')->nullable();
            $table->string('desc')->nullable();
            $table->bigInteger('id')->nullable()->index('FK_uid');
            $table->string('name')->nullable();
            $table->double('value')->nullable();
            $table->double('valuepertime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dept');
    }
};
