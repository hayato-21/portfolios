<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //このクラスを指定したら、DBからデータベース情報を取得することが出来る。

class StudyLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->first(); //usersテーブルの最初のレコードを取得する。

        foreach (range(1,3) as $num) {
            DB::table('studylogs')->insert([
                'language_id' => 1,
                'user_id' => $user->id,
                'title' => "サンプルログ{$num}",
                'status' => $num,
                'date' => Carbon::now(),
                'delete_flg' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
