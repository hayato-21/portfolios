<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'dummy@email.com',
            'password' => bcrypt('test1234'), //bcryptでハッシュ化して保存する。
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'pic' => null,
            'student_at_month' => 1,
            'nickname' => 'test太郎',
            'hoping_way' => 1,
            'comments' => 'ヤッホー',
            'delete_flg' => 0,
        ]);
    }
    //シーダーで追加せず、通常通りにログイン認証から、登録すると、delete_flgが1になる。Not Nullのため？
}
