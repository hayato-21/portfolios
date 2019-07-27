@extends('layout')

@section('styles')
    @include('share.flatpickr.styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">記録を編集する</div>
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $message)
                                    <p>{{ $message }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('studylogs.edit', ['id' => $studylog->language_id, 'studylog' => $studylog->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">タイトル</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') ?? $studylog->title }}" />
                            </div>
                            <div class="form-group">
                                <label for="status">理解度</label>
                                <select name="status" id="" class="form-control">
                                    <option value="">選択してください</option>
                                    @foreach(\App\Studylog::STATUS as $key => $val)  <!-- さっきコントローラーでSTATUSの値を渡したが、ここは名前空間で指定する。 -->
                                    <option value="{{ $key }}"
                                        {{ $key == old('status', $studylog->status) ? 'selected' : '' }}
                                        >
                                        {{ $val['label'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date">日付</label>
                                <input type="text" class="form-control" name="date" id="date" value="{{ old('date') ?? $studylog->formatted_date }}" />
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">送信</button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('share.flatpickr.scripts')
@endsection