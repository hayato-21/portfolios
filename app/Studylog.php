<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Studylog extends Model //StudyLog は ELOQUENT（ORM）の方で、study_logsと認識される。前のエラー
{                            //Studylog は ELOQUENT（ORM）の方で、studylogsと認識される。
    /**
     * 理解度定義
     */
    const STATUS = [
        1 => ['label' => '10%', 'class' => 'label-danger'],
        2 => ['label' => '20%', 'class' => 'label-danger'],
        3 => ['label' => '30%', 'class' => 'label-danger'],
        4 => ['label' => '40%', 'class' => 'label-danger'],
        5 => ['label' => '50%', 'class' => ''],
        6 => ['label' => '60%', 'class' => ''],
        7 => ['label' => '70%', 'class' => ''],
        8 => ['label' => '80%', 'class' => 'label-primary'],
        9 => ['label' => '90%', 'class' => 'label-primary'],
        10 => ['label' => '100%', 'class' => 'label-primary'],
    ];


    public function getStatusLabelAttribute()
    {
        // 理解度値
        $status = $this->attributes['status']; //$thisは、このModel、studylogattributeでカラムの値を取得している。クエリビルダは？ちょっとこっちの方が綺麗にかける

        // 定義されていいなければ空文字を返す。
        if(!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label']; //1〜10までSTATUSの値とそれに対応するlabelを返す。連想配列の返し方
    }
    public function getStatusClassAttribute()
    {
        // 理解度値
        $status = $this->attributes['status'];

        // 定義されていいなければ空文字を返す。
        if(!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class']; //1〜10までSTATUSの値とそれに対応するlclassを返す。連想配列の返し方
    }
    public function getFormattedDateAttribute() //getとAttribute以外を指定するから、formatted_data
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['date'])->format('Y/m/d');
    }

    // 疑問この定義したattributeは、どのようにして、値が渡されるのか？
    // アクセサとは、モデルクラスが本来持つデータを加工した値を、さもモデルクラスのプロパティであるかのように参照できる Laravel の機能
    // つまり、Modelクラスをインスタンス化した時に、加工されて値が渡されるイメージ。
    // Modelクラスでは、上記のように渡される値を加工出来る。
}
