<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; //ストレージにある写真を使用するため。
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\EditUser;
use Illuminate\Support\Facades\Auth;
use App\Friend;

class UserController extends Controller
{ // URL指定をするだけで、勝手に各々のアクションを行ってくれる。
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditUser $request)
    {
        // ログインユーザーを取得する。
        $user =  Auth::user();

        //Nullの場合、処理を何もせずリダイレクトする（Nullなのに、ファイルに画像を入れる処理はおかしいため）
        if(empty($request->pic)){
            return redirect()->route('users.edit',[
                'user_id' => $user->id,
            ]);
        }
        $user->pic = base64_encode(file_get_contents($request->pic->getRealPath()));
        $user->save();

        return redirect()->route('users.edit', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //これは一旦保留。
    // public function show($id)
    // {
    //     // リンクで送信されたそれぞれのidを格納する。
    //     $user_id = $id;
    //     // Idを元に、投稿者の情報を取得
    //     $user_detail = User::find($id);
    //     // Idを元に画像の情報を取得
    //     $is_image = true;
    //     if (Storage::disk('local')->exists('public/profile_images/' .$user_id. '.jpg')) {
    //         $is_image = true;
    //     }
    //     // 友達ステータス情報
    //     $status = '';

    //     return view('users.profileShow', [
    //         'user_id' => $user_id,
    //         'user_detail' => $user_detail,
    //         'is_image' => $is_image,
    //         'status' => $status,
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user(); //セッションみたいなもの。ミドルウェア。Userの情報を格納している。
        // 画像投稿
        // $is_image = false;
        // if (Storage::disk('local')->exists('public/profile_images/' .$user->id. '.jpg')) {
        //     $is_image = true;
        // }
        return view('users.profileEdit', [
            'user' => $user,
            // 'is_image' => $is_image, //さっきのは、storeでis_imageを定義したが、editでは、それを受け取る引数がそもそもなかったから、直接profEditにも飛ばしているわけではなかったから。
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUser $request)
    {
        // ログインユーザー情報を取得
        $user = Auth::user();

        // ログインユーザー情報を更新する。
        $user->student_at_month = $request->student_at_month;
        $user->nickname = $request->nickname;
        $user->hoping_way = $request->hoping_way;
        $user->comments = $request->comments;
        $user->save();

        return redirect()->route('studylogs.index',[
            'id' => 1,
        ]);
        // withにつめた値は、セッション変数を使って取り出す。
        //User情報カラムことは、Auth::user()を使えば、簡単に使える

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
