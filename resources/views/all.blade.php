@extends('layout')

@section('content')
<div class="container">
        <div class="row">
            <div class="col col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">フリーワード検索</div>
                    <form action="{{ route('free') }}">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="free" id="free" placeholder="例：Struts ECサイト" value="<?php if(!empty($frees)){ echo $frees; }  ?>" />
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </div>
                </form>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">カテゴリー検索</div>
                    <form action="{{ route('scope') }}">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="lanugage">言語</label>
                                <select name="language" id="" class="form-control">
                                    <option value="">選択してください</option>
                                    @foreach($languages as $key => $val)
                                        <option value="{{ $key }}"
                                            <?php if(!empty($language)){ if($language == $key){echo 'selected';}}  ?>>
                                            {{ $val['title'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">検索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="column col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">記録一覧</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>理解度</th>
                                <th>日付</th>
                                <th>ニックネーム</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studylogs as $studylog)
                              <tr>
                                  <td>{{ $studylog->title }}</td>
                                  <td>
                                      <span class="label {{ $studylog->status_class }}">{{ $studylog->status_label }}</span> <!-- attributeでアクセスする際は、＿ -->
                                  </td>
                                  <td>{{ $studylog->formatted_date }}</td>
                                  <td><!-- やりたいこと10。スタディログに基づくニックネームを表示させる -->
                                      @foreach($users as $user)
                                        @if($studylog->user_id === $user->id)
                                            @if(!empty($user->nickname))
                                              <a href="{{ route('friends.request', ['id' => $user->id]) }}">{{ $user->nickname }}</a>
                                            @else
                                              <a href="{{ route('friends.request', ['id' => $user->id]) }}">ニックネーム無し</a>
                                            @endif
                                          @break
                                        @endif
                                      @endforeach
                                  </td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- ページネーション -->
                    <div class="text-center">
                      {{ $studylogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection