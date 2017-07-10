<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoIncrementToAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::raw( 'ALTER TABLE account alter column id drop default' );
//        DB::raw( 'ALTER TABLE account MODIFY COLUMN id INT auto_increment' );

        Schema::table( 'account', function ( Blueprint $table ) {
            $table->integer( 'id' )->default( NULL )->change();
            $table->increments( 'id' )->change();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
