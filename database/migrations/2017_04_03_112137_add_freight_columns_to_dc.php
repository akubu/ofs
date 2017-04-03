<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFreightColumnsToDc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc', function($table) {
            $table->string('freight_charges');
            $table->string('freight_method');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc', function($table) {
            $table->dropColumn('freight_charges');
            $table->dropColumn('freight_method');
        });
        //
    }
}
