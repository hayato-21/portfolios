<?php

namespace App\Http\Requests;
use App\Studylog;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateStudylog extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $status_rule = Rule::in(array_keys(Studylog::STATUS)); //まず、StudylogのSTATUSの配列を取得する。array_keysで配列のキーを取得。ここでは1〜10。inでフィールドが指定してリストの中の値に含まれていることをバリデートする。つまりRule::in(1〜10) required|in(1〜10)

        return [
            'title' => 'required|max:30',
            'status' => 'required|'.$status_rule, // やりたいこと2 requiredのみ、valueが1〜10のもの範囲で入力させたい。→選択してくださいのvalueを 0から""にしたらrequiredのバリデーションに引っかかる
            'date' => 'required|date|before_or_equal:today',
        ];
    }
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'status' => '理解度',
            'date' => '日付',
        ];
    }
    public function messages()
    {
        return [
            'date.before_or_equal' => ':attribute には今日以前の日付を入力してください。',
        ];
    }
}
