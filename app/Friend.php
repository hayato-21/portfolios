<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /**
     * 友達ステータス定義
     */
    const STATUS = [
        0 => ['label' => ''],
        1 => ['label' => '承認待ち', 'class' => 'label-info'],
        2 => ['label' => '非承認', 'class' => 'label-danger'],
        3 => ['label' => '友達', 'class' => 'label-primary'],
    ];
    public function getStatusLabelAttribute(){
        //友達ステータスをDBから取得する（おそらく0~3）
        $status = $this->attributes['status'];
        //定義されていなければ空文字を返す
        if(!isset(self::STATUS[$status])){
            return '';
        }
        return self::STATUS[$status]['label'];
    }
    public function getStatusClassAttribute(){
        //友達ステータスをDBから取得する
        $status = $this->attributes['status'];
        //定義されていなければ空文字を返す
        if(!isset(self::STATUS[$status])){
            return '';
        }
        return self::STATUS[$status]['class'];
    }
    public function contacts(){

        return $this->hasMany('\App\Contact');
    }
}
