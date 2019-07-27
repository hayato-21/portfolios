<?php

Route::group(['middleware' => 'auth'], function(){

    // 案内、全て、フリーワード検索、カテゴリー検索
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/all', 'HomeController@all')->name('all');
    Route::get('/all/free', 'HomeController@free')->name('free');
    Route::get('/all/scope', 'HomeController@scope')->name('scope');

    // 記録表示
    Route::get('/languages/{id}/studylogs', 'StudyLogController@index')->name('studylogs.index'); //nameは、アプリケーション内で、URLを参照する時に使う名前 //最後のURLをコントールするもの
    // 記録作成
    Route::get('/languages/{id}/studylogs/create', 'StudyLogController@showCreateForm')->name('studylogs.create');
    Route::post('/languages/{id}/studylogs/create', 'StudyLogController@create');
    // 記録編集
    Route::get('/languages/{id}/studylogs/{studylog_id}/edit', 'StudyLogController@showEditForm')->name('studylogs.edit');
    Route::post('/languages/{id}/studylogs/{studylog_id}/edit', 'StudyLogController@edit');
    // 記録削除
    Route::post('/languages/{id}/studylogs/{studylog_id}/delete', 'StudyLogController@delete')->name('studylogs.delete');

    // プロフィール編集、更新(CRUDの練習)
    Route::resource('users','UserController');

    // 指定されたプロフィール表示、友達リクエスト
    Route::get('friends/{id}/request', 'FriendController@showRequest')->name('friends.request');
    Route::post('friends/{id}/request', 'FriendController@request');

    // 通知一覧 リクエスト中
    Route::get('confirm', 'FriendController@confirm');
    // 承認
    Route::get('authen', 'FriendController@showAuthen')->name('friends.authen');
    Route::post('authen', 'FriendController@authen');
    // 承認しない
    Route::get('notAuthen', 'FriendController@showNotAuthen')->name('friends.notAuthen');
    Route::post('notAuthen', 'FriendController@notAuthen');
    // メッセージ一覧
    Route::get('message', 'FriendController@messages')->name('friends.message');
    // 友達一覧
    Route::get('friendAll', 'FriendController@friendAll')->name('friends.friendAll');
    // 個人連絡
    Route::get('contact', 'ContactController@showContact')->name('contacts.contact');
    Route::post('contact', 'ContactController@contact');

});


Auth::routes();

// Laravelには、会員登録後に自動的にログイン機能がある。