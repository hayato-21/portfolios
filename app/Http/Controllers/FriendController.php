<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Friend;

class FriendController extends Controller
{

    public function showRequest($id)
    {
        // リンクで送信されたそれぞれのidを格納する。
        $user_id = $id;
        // Idを元に、投稿者の情報を取得
        $user_detail = User::find($id);
        // Idを元に画像の情報を取得
        // $is_image = false;
        // if (Storage::disk('local')->exists('public/profile_images/' .$user_id. '.jpg')) {
        //     $is_image = true;
        // }
        // 友達ステータス情報の取得の流れ
        // ログインしているユーザーのIDを取得
        $login_user_id = Auth::user()->id;

        //パターン1($login_user_id === requested_user && $user_id === $received_user)
        $friend = Friend::where('requested_user', $login_user_id)->where('received_user', $user_id)->first();//まちがって二度登録されている場合があるから
        //ユーザーがわかりやすく認識するため。
        $your = '';
        if(empty($friend)){
            //パターン2($login_user_id === received_user && $user_id === requested_user)
            $friend = Friend::where('requested_user', $user_id)->where('received_user', $login_user_id)->first();
            $your = 'あなたの';
        }
        if(!empty($friend)){
            // その取得した$friend情報を元に、status情報を取得
            $status = $friend->status;
        }else{
            // 無ければ空文字を渡す
            $status = '';
        }
        // やりたいこと13 SQL文を条件に応じて、ステータス表示を変える。→最初にSQL文を実行し、
        // やりたいこと14 これだと自分にも友達リクエストを送れてしまう。→if文で、解決。
        return view('users.profileShow', [
            'user_id' => $user_id,
            'user_detail' => $user_detail,
            // 'is_image' => $is_image,
            'status' => $status,
            'your' => $your,
        ]);
    }
    public function request($id)
    {
        //ログインユーザーのIDを格納する
        $requested_user = Auth::user()->id;
        //友達テーブル追加の処理を記述する
        $friend = new Friend();
        $friend->requested_user = $requested_user;
        $friend->received_user = $id;
        $friend->status = 1;
        $friend->save();
        // 直前にインサートしたステータスの格納
        $status = $friend->status;

        // リンクで送信されたそれぞれのidを格納する。
        $user_id = $id;
        // Idを元に、投稿者の情報を取得
        $user_detail = User::find($id);
        // Idを元に画像の情報を取得
        $is_image = false;
        if (Storage::disk('local')->exists('public/profile_images/' .$user_id. '.jpg')) {
            $is_image = true;
        }

        return view('users.profileShow',[
            'user_id' => $user_id,
            'user_detail' => $user_detail,
            'is_image' => $is_image,
            'status' => $status,
        ]);
    }
    public function confirm()
    {
        //ログインユーザーの値を代入する
        $id = Auth::user()->id;
        // １.リクエストしたユーザーがログインユーザー、かつステータスが1の友達テーブル情報を全て取ってくる
        $friends = Friend::where('requested_user', $id)->where('status', 1)->get(); //もし同じ情報が存在している場合、どうするか？同じものも取得してしまう。
        // ２.取得した友達のテーブルのreceived_userと一致するUser情報をとる。
        if(!empty($friends)){ //無い場合もあるため
            foreach($friends as $key => $val){
                // $val['received_user']  === users.id
                $received = User::where('id', $val['received_user'])->first();
                $friends[$key]['received'] = $received;
            }
        }
        // 現在のページ情報を送る
        $current_page = 1;

        return view('users.notice',[
            'id' => $id,
            'current_page' => $current_page,
            'friends' => $friends,
        ]);
    }
    public function showAuthen()
    {
        //ログインユーザーの値を代入する
        $id = Auth::user()->id;
        // １.リクエストされたユーザーがログインユーザーの友達テーブル情報を全て取ってくる
        $friends = Friend::where('received_user', $id)->where('status', 1)->get(); //もし同じ情報が存在している場合、どうするか？同じものも取得してしまう。
        // ２.取得した友達のテーブルのrequested_userと一致するUser情報をとる。
        if(!empty($friends)){ //無い場合もあるため
            foreach($friends as $key => $val){
                // $val['received_user']  === users.id
                $requested = User::where('id', $val['requested_user'])->first();
                $friends[$key]['requested'] = $requested;
            }
        }
        // 現在のページ情報を送る
        $current_page = 2;

        return view('users.notice',[
            'id' => $id,
            'current_page' => $current_page,
            'friends' => $friends,
        ]);
    }
    public function messages()
    {
        // ログインユーザーを変数に格納する。
        $login_user_id = Auth::user()->id;
        // ログインユーザーで、友達かつ、requested_user, received_userは、全てのFriend情報を取得する。多分orWhereで全てダメになっている気がする。→あれ？received_userの引数を指定したら、いきなり出現した。笑
        $friends = Friend::where('status', 3)->where('requested_user', $login_user_id)->orWhere('received_user', $login_user_id)->get();
        // Friend情報を元にContact情報にリレーションし、かつ最後に送信した人が相手で、送信したメッセージを10文字で表示する。
        if(!empty($friends)){
            foreach($friends as $key => $val){
                $first = $val->contacts()
                ->where('received_user', $login_user_id)
                ->orderBy('created_at', 'desc')
                ->first();
                // もしあれば、取得したFriend情報の配列にmessageを追加し、そこに取得したContact情報を追加する。無ければ、空文字を追加する。
                if(!empty($first)){
                    $friends[$key]['message'] = $first;
                    $partner_detail = User::find($first['sent_user']);
                    if($partner_detail){
                        $friends[$key]['partner_detail'] = $partner_detail;
                    }
                }
            }
        }
        // もし、相手の最新のメッセージがあった際に多次元配列をよく理解しよう。
        // 現在のページ情報を送る
        $current_page = 3;

        return view('users.notice',[
            'current_page' => $current_page,
            'friends' => $friends,
        ]);
    }
    public function authen(Request $request)
    {
        // 承認するは、条件に一致する()friendテーブルの、status=1から、status=3にする。
        // 引数を指定するパターンは？。更新さえすれば、whereで条件指定しているため、自動的に消える。リダイレクトで良い。
        // 今、requested_idは、自分（Auth::user()->id）引数が欲しい
        // Friend::where('received_user', Auth::user()-id)->where('requested', $id)を取得する。
        // つまり、リクエストしたユーザーの$idが欲しい。
        $login_user_id = Auth::user()->id;
        $friend = Friend::where('received_user', $login_user_id)->where('requested_user', $request->id)->update(['status' => 3]);

        return redirect()->route('friends.authen',[
        ]); //おそらくGETで、引数が無いのにも関わらず、POSTで引数を指定し、リダイレクトをしているから？
    }
    public function showNotAuthen(Request $request){  //idだと、too few argumentsになるが？Requestにするとならない。多分トークンの関係？

        return view('users.rejectConfirm',[
            'id' => $request->id,
        ]);
    }
    public function notAuthen(Request $request)
    {
        //承認しないは、条件に一致するfriendテーブルの、status=1から、status=2にする。
        $login_user_id = Auth::user()->id;
        $friend = Friend::where('received_user', $login_user_id)->where('requested_user', $request->id)->update(['status' => 2]);

        return redirect()->route('friends.authen',[
        ]);
    }
    public function friendAll()
    {
        //ログインユーザーの値を代入する
        $login_user_id = Auth::user()->id;

        // まずは、分けてみる。メッセージ一覧では一緒にする。
        // 1.パターン1。ログインユーザーがリクエストして、承認された（3）相手のユーザー情報を取得する。
        $friendOne = Friend::where('requested_user', $login_user_id)->where('status', 3)->get();
        // 2.次にfriend情報を元に、User情報(リクエストされた側)を取得
        if(!empty($friendOne)){
            foreach($friendOne as $key => $val){
                $friendReceived = User::where('id', $val['received_user'])->first();
                $friendOne[$key]['friendReceived'] = $friendReceived;
            }
        }
        // 1.パターン2。ログインユーザーがリクエストされた、承認した（3）リクエストした相手のユーザー情報を取得する。
        $friendTwo = Friend::where('received_user', $login_user_id)->where('status', 3)->get();
        // 2.次にfriend情報を元に、User情報(リクエストした側)を取得
        if(!empty($friendTwo)){
            foreach($friendTwo as $key => $val){
                $friendRequested = User::where('id', $val['requested_user'])->first();
                $friendTwo[$key]['friendRequested'] = $friendRequested;
            }
        }

        return view('users.friendAll', [
            'friendOne' => $friendOne,
            'friendTwo' => $friendTwo,
        ]);
    }
}
