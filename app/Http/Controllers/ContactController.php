<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SubmitContact;

class ContactController extends Controller
{
    public function showContact(Request $request)
    {
        // 相手の名前と画像表示用の情報を格納
        // ログインユーザーIDを格納する。
        $login_user_id = Auth::user()->id;
        // 画面の画像表示用のログインユーザー情報の取得。
        $login_user_detail = User::find($login_user_id);
        // リクエストされたIDを格納する。
        $partner_user_id = $request->id;
        // 画面の画像表示用のパートナーユーザー情報の取得
        $partner_user_detail = User::find($partner_user_id);

        // ログインユーザーとリクエストされた受け取ったIDを元に、Friend情報を取得する。
        // 受け取ったユーザーのIDが、requested_user OR received_userの場合。これを条件分岐させる。
        $friend = Friend::where('status', 3)->where('received_user', $login_user_id)->where('requested_user', $partner_user_id)->first();
        if(empty($friend)){// received（承認した側）OK。この条件分岐がちゃんと出来ていない出来ていない。てかこれって、friendが空の場合は、この処理やるけど、空じゃなかったらと、クエリが実行されるはずがない。→解決。
            $friend = Friend::where('status', 3)->where('requested_user', $login_user_id)->where('received_user', $partner_user_id)->first();
        }
        // 取得したfriendテーブルのidで、Contactテーブルの外部キーから一致する情報を取得する。
        // 解決！！- Call to a member function contacts() on null 現状このエラーが出る。→redirect()を決してトライ //多分リダイレクトする時に、friendAllから渡していた'id' => friednReceived or friendRequestedがなかったため、相手の情報が入らず、クエリが実行されず空であった。
        $contact = $friend->contacts()->get();

        return view('users.contact',[
            'id' => $request->id,
            'friend_id' => $friend->id,
            'login_user_detail' => $login_user_detail,
            'partner_user_detail' => $partner_user_detail,
            'friend' => $friend,
            'contact' => $contact,
        ]);
    }
    public function contact(SubmitContact $request) //プロフィール編集を見ると、バリデーションで$requestでPOST通信を受け取って。バリデーションはrequired|max:255。
    // POST Request すればとりあえず、一通り送ることが出来るんだな。
    {
        // リクエストで送られてきた情報を。
        $friend_id = $request->friend_id;
        $partner_id = $request->partner_id;
        $messages = $request->messages;
        // 現在のフレンドテーブルの情報を持ってくる。
        $current_friend = Friend::find($friend_id);

        // friend_idを元に、フレンドテーブルを紐付けて、コンタクトテーブルにインサートする。
        $contact = new Contact();
        $contact->sent_user = Auth::user()->id;
        $contact->received_user = $partner_id;
        $contact->messages = $messages;
        $current_friend->contacts()->save($contact);

        // このコンタクトブレードの中のfriend IDが欲しい。そしてそのIDと共にContactテーブルにインサートする。
        return redirect()->route('contacts.contact',[
            'id' => $partner_id,
        ]);
    }
}
