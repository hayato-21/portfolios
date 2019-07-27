<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPicOthersToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('pic')->nullable()->change(); //null値を許容する //画像バイナリを使用するため、string→textに変更する。
            $table->integer('student_at_month')->nullable()->change();
            $table->string('nickname', 15)->nullable()->change();
            $table->integer('hoping_way')->nullable()->change();
            $table->string('comments', 50)->nullable()->change();
            $table->tinyInteger('delete_flg')->default();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pic');
            $table->dropColumn('student_at_month');
            $table->dropColumn('nickname');
            $table->dropColumn('hoping_way');
            $table->dropColumn('comments');
            $table->dropColumn('delete_flg');
        });
    }
}
