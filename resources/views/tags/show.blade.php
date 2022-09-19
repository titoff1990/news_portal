@extends('layouts.app')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold">Обсуждаемые новости с тегом "{{ $tag->title }}"</h4>
    @if($tagNews->isNotEmpty())
        @include('news.news-block', ['sortedNews' => $tagNews])
    @else
        <h4>Информация отсутствует</h4>
    @endif
@endsection
