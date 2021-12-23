<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManyatinterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manyatinterests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('amount');
            $table->string('interest_rate');
            $table->string('total_amount')->nullable();
            $table->string('payment_pariod_start');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manyatinterests');
    }
}
