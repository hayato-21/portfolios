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
            $table->text('pic')->default('pic');
            $table->integer('student_at_month')->default('1');
            $table->string('nickname', 15)->default('ニックネーム無し');
            $table->integer('hoping_way')->default(2);
            $table->string('comments', 50)->default('コメントはまだありません。');
            $table->tinyInteger('delete_flg')->default(0);
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
