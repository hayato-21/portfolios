<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudylogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studylogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned(); //数値カラムで符号を使わない
            $table->string('title', 30);
            $table->integer('status')->default(1);
            $table->date('date');
            $table->tinyInteger('delete_flg')->default(0);
            $table->timestamps();

            // 外部キーを設定する
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studylogs');
    }
}
