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
            $table->text('pic')->default("");
            $table->integer('student_at_month')->default("");
            $table->string('nickname', 15)->default("");
            $table->integer('hoping_way')->default("");
            $table->string('comments', 50)->default("");
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
        });
    }
}
