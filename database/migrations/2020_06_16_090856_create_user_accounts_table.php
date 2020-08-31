<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::create('user_accounts', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->bigInteger('user_id')->unsigned();
        //     $table->bigInteger('account_id')->unsigned();
        //     $table->timestamps();
        // });

        // Schema::table('user_accounts', function (Blueprint $table) {
        //     $table->foreign('user_id')
        //         ->references('id')
        //         ->on('users')
        //         ->onDelete('cascade');

        //     $table->foreign('account_id')
        //         ->references('id')
        //         ->on('accounts')
        //         ->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
}