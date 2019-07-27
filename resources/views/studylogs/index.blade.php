@extends('layout')

@section('styles')
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
        <div class="row">
            <div class="col col-md-4">
                <nav class="panel panel-default">
                    <div class="panel-heading">言語</div>
                    <div class="list-group">
                        @foreach($languages as $language)
                            <a href="{{ route('studylogs.index', ['id' => $language->id]) }}" class="list-group-item {{ $current_language_id === $language->id ? 'active' : ''}}">
                                {{ $language->title }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="column col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">記録</div>
                    <div class="panel-body">
                        <div class="text-right">
                            <a href="{{ route('studylogs.create', ['id' => $current_language_id]) }}" class="btn btn-default btn-block"> <!-- indexアクションで、３種類のデータを渡している。'id'に格納' -->
                                記録を追加する
                            </a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>理解度</th>
                                <th>日付</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studylogs as $studylog) <!-- これ全ての勉強記録情報を一旦持ってきてるから、重いかもしれない。 -->
                              <!-- やりたいこと7。ここにdelete_flg === 0 のスタディログのみ表示させる やりたいこと10、ログインしたユーザーのみの、記録を表示。-->
                              <tr>
                                  <td>{{ $studylog->title }}</td>
                                  <td>
                                      <span class="label {{ $studylog->status_class }}">{{ $studylog->status_label }}</span> <!-- attributeでアクセスする際は、＿ -->
                                  </td>
                                  <td>{{ $studylog->formatted_date }}</td><!-- アクセサで加工されたデータは、formatted_dateのように、「 ＿ 」アンダーバーをつける必要があるが、そもそもCONSTは加工していないから、通常のPHPの連想配列の指定の仕方でよい。てことは、本来foreachで配列の展開が必要なところModelで、アクセサでデータを加工することで、欲しい情報をforeach文の中にforeach文にしなきゃいけないところを、ただアクセスのみに出来る-->
                                  <td><a href="{{ route('studylogs.edit', ['id' => $studylog->language_id, 'studylog_id' => $studylog->id]) }}">編集</a></td><!-- 上の発見が出来たのは、htmlを書いたから、ちゃんと書こう。 -->
                                  <td>
                                      <form action="{{ route('studylogs.delete',['id' => $studylog->language_id, 'studylog_id' => $studylog->id]) }}" method="POST">  <!-- $studylog->idをPOST通信で渡して、deleteアクションの引き数として、論理削除 Web.phpに指定しているので、2つの引数をちゃんと指定しないといけない。-->
                                          {{ csrf_field() }} <!-- これがあっても、419のエラーが出る。→おそらくforeach文で、formをたくさんつくのがいけないと仮定すると、aタグを使うか、非同期処理を使うか、あれ？時間が経過したら、治った？なんかLaravelの青本で、formはGoogleの開発環境でエラーになることがあるて-->
                                          <button type="submit" class="btn btn-sub"><i class="far fa-trash-alt btn-red"></i></button>
                                      </form>
                                  </td> <!-- やりたいこと7 記録を論理削除するアクションを作り、redirectする-->
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection