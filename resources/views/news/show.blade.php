@extends('layouts.app')
@section('content')
    <div class="card shadow rounded-sm mt-3 mb-4 w-50 border-light">
        <img class="card-img-top img-fluid" src="{{ asset(Storage::url($news->image)) }}" alt="Card image cap">
        <div class="card-body">
            <h4 class="">{{ $news->name }}</h4>
            <p class="card-text">{{ $news->content }}</p>
        </div>
        <div class="card-footer text-center">
            {{$news->name}}
        </div>
    </div>
    <div class="card shadow rounded-sm mt-3 mb-4 w-50 border-light">
        <div class="card-header">
            Комментарии
        </div>
        <div class="card-body">
            <div class="card" id="comment-content">
                @include('news.comments', $comments)
            </div>
            <form id="myForm">
                <label for="name">Введите комментарий</label>
                <input type ="text" name="content" id="content" class="form-control mt-2 mb-2" value="{{ old('name') }}">
                <input type="hidden" name="key" id="key" value="{{$news->getKey()}}">
                <input type="hidden" name="url" id="url" value="{{route('comment.store')}}">
                <button type="submit" id="btn-save" class="btn btn-primary btn-sm mt-2 js-add-comment">Добавить комментарий</button>
            </form>
        </div>
    </div>
@endsection
