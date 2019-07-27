<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = ['html&css', 'javascript&jQuery', 'php&mysql', 'java', 'struts&mysql', 'その他'];

        foreach($titles as $title){
            DB::table('languages')->insert([
                'title' => $title,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
