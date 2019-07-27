<?php

namespace App;

use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Userテーブルと言語(language)テーブルと紐付けたい時。
    // public function languages()
    // {
    //     return $this->hasMany('App\Language');
    // }

    // UserとStudylogを紐付け。(※紐付けるのみで、取得は記述が必要)（全体用）ここはブログでは、languageだ
    public function mystudylogs()
    {
        return $this->hasMany('App\Studylog'); //$thisはユーザー情報などが入る。hasMany結合は何を基準に結合させるのか。→外部キーを元に結合する
    }

    // 自分のUserとStudylogを紐づけ
    // public function mystudylogs(int $login_user_id)
    // {
    //     return $this->hasMany('App\Studylog')->where('user_id', $login_user_id);
    // }

    /**
     * 何月生定義
     */
    const STUDENT = [
        1 => ['month' => '1月生'],
        2 => ['month' => '2月生'],
        3 => ['month' => '3月生'],
        4 => ['month' => '4月生'],
        5 => ['month' => '5月生'],
        6 => ['month' => '6月生'],
        7 => ['month' => '7月生'],
        8 => ['month' => '8月生'],
        9 => ['month' => '9月生'],
        10 => ['month' => '10月生'],
        11 => ['month' => '11月生'],
        12 => ['month' => '12月生'],
    ];

    //当初attributeを使おうとしたが、Modelを操作するものなので、使えなかった
    public function getStudentMonth(int $id)
    {
        return self::STUDENT[$id]['month'];
    }

    /**
     * 希望進路定義
     */
    const HOPING = [
        1 => ['way' => '自社開発'],
        2 => ['way' => '客先常駐'],
        3 => ['way' => 'システムエンジニア'],
        4 => ['way' => 'データベースエンジニア'],
        5 => ['way' => 'ネットワークエンジニア'],
        6 => ['way' => 'インフラエンジニア'],
        7 => ['way' => 'ウェブエンジニア'],
    ];
    public function getHopingWay(int $id)
    {
        return self::HOPING[$id]['way'];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * ★ パスワード再設定メールを送信する
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)->send(new ResetPassword($token));
    }
}
