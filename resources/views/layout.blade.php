<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>StudyLog App</title>
  @yield('styles')
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <!-- space-betweenを指定すると子要素を分ける。span -->
    <header>
        <nav class="my-navbar"><!-- この場合、aとdivで分割され、さらにspanが優先されるから、divが下に落ちる。。 -->
            <a class="my-navbar-brand" href="{{ route('all') }}">StudyLog</a>
            <div class="my-navbar-control" id="hunbarger">
                @if(Auth::check())
                <div class="menu-trigger js-toggle-sp-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <!-- ナビゲーション -->
                <div class="nav-menu js-toggle-sp-menu-target">
                    <ul class="menu">
                        <li class="menu-item"><span class="nav-login-name">ようこそ、{{ Auth::user()->name }}さん</span></li>
                        <li class="menu-item"><a class="menu-link" href="{{ route('studylogs.index',['id' => 1]) }}">マイページ</a></li>
                        <li class="menu-item"><a class="menu-link" href="{{ route('all') }}">みんなの記録一覧</a></li><!---->
                        <li class="menu-item"><a class="menu-link" href="{{ route('friends.friendAll') }}">友達一覧</a></li>
                        <li class="menu-item"><a class="menu-link" href="/confirm">通知</a></li><!-- URL指定で、Auth::user()の値を送ってしまうと、他人にアクセス出来る。 -->
                        <li class="menu-item"><a class="menu-link" href="{{ route('users.edit', ['user_id' => Auth::user()->id]) }}">プロフィール編集</a></li><!-- Authは、middlewareでルート全体に処理をかけているから良いんだ-->
                        <li class="menu-item"><a id="logout" class="menu-link" href="#">ログアウト</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
                @else
                <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
                |
                <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
                @endif
            </div>
        </nav>
    </header>
<main>
    @yield('content')
</main>
<footer id="footer">
    Copyright StudyLog App all right reserved.
</footer>
@if(Auth::check()) <!-- Authは、middlewareでルート全体に処理をかけているから良いんだ-->
<script>
    document.getElementById('logout').addEventListener('click', function(event){
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });
</script>
@endif
@yield('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script>
//ハンバーガーメニュー
$(function(){
    $('.js-toggle-sp-menu').on('click', function(){
    $(this).toggleClass('active');
    $('.js-toggle-sp-menu-target').toggleClass('active');
    });
});
</script>
</body>
</html>