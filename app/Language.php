<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function studylogs()
    {
        return $this->hasMany('App\Studylog');
        //親テーブルに指定する。ここで、DBの紐付けを行うのでControllerの方で紐付けを行わなく良い。もちろんModel同士で。
        // $this->hasMany('App\Studylog', 'language_id', 'id'); 省略しないで書き方
        // DBの紐付けは、Controllerでfind検索するか、
        // 親テーブルのModelは、リレーションとアクセサによるデータの加工
        // 子テーブルのModelは、アクセサによるデータの加工のみ？
        // hasOneは、リレーションの1つだけDBを返し、hasManyはリレーションの全てのDBを返す。
        // hasManyで複数とってきたDBの指定方法は？
    }
}
