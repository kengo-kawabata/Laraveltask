<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToFolders extends Migration
{
    /**
     * Run the migrations.
     * foldersテーブルに user_id 列を追加する
     * 
     * @return void
     */
    public function up()
    {
        Schema::table('folders', function (Blueprint $table) {
            // BIGINT相当の列をUNSIGNED（MySQL）として追加する
            $table->bigInteger('user_id')->unsigned();

            /* 外部キーを'user_id'列に設定する（実在するIDの値以外はDBに入らないようにする） */
            // foreign()：外部キーを設定する列を指定する
            // ->references()：参照する列名を指定する
            // ->on()：参照するテーブル名を指定する
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     * foldersテーブルの user_id 列を削除する
     * 
     * @return void
     */
    public function down()
    {
        Schema::table('folders', function (Blueprint $table) {
            // user_id 列を削除する
            $table->dropColumn('user_id');
        });
    }
}