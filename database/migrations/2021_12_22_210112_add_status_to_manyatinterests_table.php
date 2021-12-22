<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToManyatinterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manyatinterests', function (Blueprint $table) {
            $table->enum('status', ['0', '1'])->default(0)->comment('0 = unpaid, 1=paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manyatinterests', function (Blueprint $table) {
            //
        });
    }
}
