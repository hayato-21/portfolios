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
            $table->text('pic')->nullable()->change();
            $table->integer('student_at_month')->nullable()->change();
            $table->string('nickname', 15)->nullable()->change();
            $table->integer('hoping_way')->nullable()->change();
            $table->string('comments', 50)->nullable()->change();
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
            $table->dropColumn('pic')->nullable(false)->change();
            $table->dropColumn('student_at_month')->nullable(false)->change();
            $table->dropColumn('nickname')->nullable(false)->change();
            $table->dropColumn('hoping_way')->nullable(false)->change();
            $table->dropColumn('comments')->nullable(false)->change();
        });
    }
}
