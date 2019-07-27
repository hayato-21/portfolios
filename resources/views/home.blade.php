@extends('layout')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col col-md-offset-3 col-md-6">
              <nav class="panel panel-default">
                  <div class="panel-heading">
                      ようこそ、Studylogへ。試しにhtml&css言語で追加してみましょう
                  </div>
                  <div class="list-group">
                  <a href="#" class="list-group-item active">
                        {{ $current_language->title }}
                  </a>
                        <!-- やりたいこと8 残された課題 -->
                        <!-- @foreach($languages as $language)
                            <a href="{{ route('home', ['id' => $language->id]) }}" class="list-group-item {{ $current_language_id === $language->id ? 'active' : ''}}">
                                {{ $language->title }}
                            </a>
                        @endforeach -->
                    </div>
                  <div class="panel-body">
                      <div class="text-center">
                          <a href="{{ route('studylogs.create', ['id' => $current_language_id]) }}" class="btn btn-primary">
                              記録追加ページへ
                          </a> <!-- 原因は、studylogs.createへRouteを設定しているのにid情報を渡していないから、エラーになるわ -->
                      </div>
                  </div>
              </nav>
          </div>
      </div>
  </div>
@endsection