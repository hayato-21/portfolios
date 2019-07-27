<?php

namespace App\Http\Controllers;

use App\Language;
use App\Studylog;
use App\User;
use App\Http\Requests\CreateStudylog;
use App\Http\Requests\EditStudylog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyLogController extends Controller
{
    public function index(int $id){

        // 全ての言語を取得する
        $languages = Language::all(); //Modelを通して、DBを操作するため、ModelはDBのテーブルの単数形
         // ★ ユーザーのフォルダを取得する（タスクも個人で設定する場合、今回は共通の言語で登録してもらうため、認証いらない。）
         // $languages = Auth::user()->languages()->get(); これだと、ユーザーに紐づくので、だめ。

        // 選ばれた言語を取得する
        $current_language = Language::find($id); // 選ばれた1行分のデータを返す。

        // ログインユーザーを取得する
        $user = Auth::user();

        // ログイン情報に基づくスタディログを取得し、delete_flg=0かつ、スタディログと選ばれた言語を取得する。後ろに条件句を指定したら、リレーションで関連しているの絞り出せる。やりたいこと9完了
        $studylogs = $user->mystudylogs()->where('language_id',$current_language->id)->where('delete_flg', 0)->orderBy('date','desc')->get();

        return view('studylogs/index', [
            'languages' => $languages, //注意、参照する際は、Keyを指定する。
            'current_language_id' => $current_language->id,
            'studylogs' => $studylogs,
        ]);
    }
    /**
     *  GET /languages/{id}/studylogs/create
     * */
    public function showCreateForm(int $id){

        // 理解度のSTATUS情報を取得する。Studylog.phpで定義した
        $status = Studylog::STATUS;

        return view('studylogs/create', [
            'language_id' => $id,
            'status' => $status,
        ]);
    }
    public function create(int $id, CreateStudylog $request)
    {
        $current_language = Language::find($id);

        $studylog = new Studylog(); // Modelインスタンスを作成
        $studylog->title = $request->title;
        $studylog->status = $request->status;
        $studylog->date = $request->date;
        $studylog->user_id = Auth::user()->id; // みたいな記述が欲しい。果たして、これが通用するのか→できた。★ ユーザーに紐付けて保存

        // studylogsのテーブルにuser_idが追加されたので、DB情報を追加しないといけない

        // ★ ユーザーに紐付けて保存。ちなみに違うのは、newを指定しなくても良い。use ....\Authのインスタンスのuser()メソッドを使うと、Userモデルが取得出来る。Userモデルの中のstudy(hasMany)メソッドを使用する。どのUserがログインしているかのログイン情報は、user()メソッドで、自動的に判別してくれる
        // Auth::user()->studylogs()->save($studylog);
        $current_language->studylogs()->save($studylog);

        return redirect()->route('studylogs.index', [
            'id' => $current_language->id,
        ]);
    }
    public function showEditForm(int $id, int $studylog_id) //この$studylog_idは、編集のaタグを押した瞬間渡される
    {
        $studylog = Studylog::find($studylog_id);

        return view('studylogs/edit', [
            'studylog' => $studylog,
        ]);
    }
    public function edit(int $id, int $studylog_id, EditStudylog $request)
    {
        // 1
        $studylog = Studylog::find($studylog_id);

        // 2
        $studylog->title = $request->title;
        $studylog->status = $request->status;
        $studylog->date = $request->date;
        $studylog->save();

        return redirect()->route('studylogs.index', [
            'id' => $studylog->language_id,
        ]);
    }
    public function delete(int $id, int $studylog_id) //これはまず、languageのid。あれ？studylog_idの情報をどうやって渡すんだ？
    {
        //1
        $studylog = Studylog::find($studylog_id);

        //2 delete_flgの値を用意
        $param = [
            'delete_flg' => 1,
        ];
        //2
        $studylog->where('id',$studylog->id)->update($param);

        return redirect()->route('studylogs.index',[
            'id' => $studylog->language_id,
        ]);
    }
}