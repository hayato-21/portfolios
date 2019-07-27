<?php

namespace App\Http\Controllers;

use App\Language;
use App\Studylog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(int $id=1)
    {
        // 全ての言語を取得する
        $languages = Language::all();
        // 選ばれた言語を取得する
        $current_language = Language::find($id);
        // ログインユーザーを取得する
        $user = Auth::user();
        // ログイン情報に基づく記録を1つ取得する。（これは確認のみ）
        $studylog = $user->mystudylogs()->first();
        // 1つも勉強記録が無ければ、ホームページをレスポンスする。（もちろんdelete_flg = 0,1関係なく取得するため、一度登録し空っぽでも、最初の画面には遷移されない。論理削除がはまった。）
        if(is_null($studylog)){
            return view('home', [
                'languages' => $languages,
                'current_language' => $current_language,
                'current_language_id' => $current_language->id, //この3つ値を渡したら解決。
            ]);
        }
        // 勉強記録（delete_flg関係なしに、）があればそのフォルダのタスク一覧にリダイレクトする。//html&cssの記録用。//注意、参照する際は、Keyを指定する。
        return redirect()->route('studylogs.index', [
            'id' => $id,
        ]);
        // 'id' => $current_language->id,

        // 下記のは試したこと、やりたいこと8 新規登録後の勉強記録への誘導と言語の選択。残された課題
        // 全ての言語を取得する
        // $languages = Language::all();
        // if(empty($id)){
            // 初めにhtml&css言語を取得する(第二引数に$first=1)
            // $current_language = Language::find($first);
        // }else{
            // 選ばれた言語を取得する
            // $current_language = Language::find($id);
        // }

        // html&css言語を取得する→これだと画面で、html&cssの情報のまま。
       //かと言って、int $idだと、最初の引数が返せない。→引数にデフォルト設定したら良いのでは？（だめ、デフォルトが変わらない。）→ homeへ飛ばした時に$idを渡す、(だめ、デフォルトと変わらない。)→$id,$first=1で分ける。（最初のデフォルト必ず指定しないといけない。）→

       // Undefined variable: current_language home.blade.php
       // 多分これは、いろんな場面で出てくる。
       // 考えられるエラーは、イメージとして、index.blade.phpとhome.blade.phpでデータが衝突している。
       // セッションに入っている値を理解していない。
       // エラーの場合分けをしよう。
       // 引数を4つリターンすると、ログアウト、会員登録画面、パスワード変更画面には、いける。

    }
    public function all()
    {
        // 全てのユーザー情報を取得する。delete_flg = 1の記録しかないユーザーは取らない。
        $users = User::all();
        // 全ての言語を取得する
        $languages = Language::all();
        // デリートフラグが0で、かつ最新の記録をとる。12件ずつ勉強記録を取得する。
        $studylogs = Studylog::where('delete_flg', 0)->orderBy('date', 'desc')->paginate(12);
        // スタディログに紐づくユーザー情報をとる(belong to)?
        // foreach studylogs,studylog->user_id === user->id, foreach文の中に、for or foreach文を用意して、見つかった時点でbreakする。user->idのまとまりの変数。
        // break,continue
        // やりたいこと 10完了。


        // 選ばれた言語を取得する
        return view('all', [
            'studylogs' => $studylogs,
            'users' => $users,
            'languages' => $languages,
        ]);
    }

    public function free(Request $request)
    {
        // 全ての言語を取得する
        $languages = Language::all();
        //リクエストされた情報を変数に入れる。
        $frees = $request->free;
        // 全てのユーザー情報を取得する。delete_flg = 1の記録しかないユーザーは取らない。
        $users = User::all();
        // デリートフラグが0、最新のものから、検索からタイトルと一致した、12件ずつ勉強記録を取得する。Nullだったら、全部OK。
        $studylogs = Studylog::where('delete_flg', 0)
                             ->where('title', 'like', '%' . $frees . '%')
                             ->orderBy('date', 'desc')
                             ->paginate(12);

        return view('all', [
            'studylogs' => $studylogs,
            'users' => $users,
            'languages' => $languages,
            'frees' => $frees,
        ]);
    }
    public function scope(Request $request)
    {
        // Null値と分ける。Nullが入っていると何も引っかからないから。

        //リクエストされた情報を変数に入れる。（言語）
        $language = $request->language;

        // デリートフラグが0、最新のものから、検索からタイトルと一致した、12件ずつ勉強記録を取得する。Nullの場合と分ける。
        if(empty($language)){
            $studylogs = Studylog::where('delete_flg', 0)
                             ->orderBy('date', 'desc')
                             ->paginate(12);
        }else{
            $studylogs = Studylog::where('delete_flg', 0)
                             ->where('language_id', $language)
                             ->orderBy('date', 'desc')
                             ->paginate(12);
        }
        // 全てのユーザー情報を取得する
        $users = User::all();
        // 全ての言語を取得する
        $languages = Language::all();
        // 検索保持todo やりたいこと11

        return view('all', [
            'studylogs' => $studylogs,
            'users' => $users,
            'languages' => $languages,
            'language' => $language,
        ]);
    }
}
