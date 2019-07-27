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
            $table->text('pic')->nullable();
            $table->integer('student_at_month')->nullable();
            $table->string('nickname', 15)->nullable();
            $table->integer('hoping_way')->nullable();
            $table->string('comments', 50)->nullable();
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
