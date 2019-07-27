<?php

namespace App\Http\Requests;

use App\Studylog;
use Illuminate\Validation\Rule;

class EditStudylog extends CreateStudylog
{

    //authorize,rule,attributeは、親のRequestをそのまま使うので、おっけ
    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function($item){ //array_mapは、指定した配列の要素にコールバック関数を適用する
            return $item['label'];  //第1引数に、配列の各要素に適用するコールバック関数、第2引数にコールバックを適用する配列
        }, Studylog::STATUS);  //適用する配列ということは、Studylog::STATUSを引数（$item）として、コールバック関数の引数に渡す

        // 下記の記述がないと、Array to String conversionのエラーが出る。
        // $status_labels = ['10%','20%'~]はという配列形式である。そのまま表示するとこの配列が文字列に変換される。なので、上記のエラーが発生する。
        // つまり、配列を文章として、扱うには、配列を文字列にしてあげる必要がある。その時に使う関数がimplode
        // 下記では、第一引数と第二引数を交互に結合している。順番は、最初に、がつくが、最後につくがの違い。
        $status_labels = implode('、', $status_labels);

        return $messages + [
            'status.in' => ':attribute には' . $status_labels. 'のいずれかを選択してください。', //statusのinルールという指定
        ];
    }
}
