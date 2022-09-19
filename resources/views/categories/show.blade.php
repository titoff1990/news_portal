@extends('layouts.app')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold">Новости категории "{{ $category->name }}"</h4>
    @if($categoryNews->isNotEmpty())
    @include('news.news-block', ['sortedNews' => $categoryNews])
    @else
        <h4>В данной категории нет пока нет новостей...</h4>
        @endif
@endsection
