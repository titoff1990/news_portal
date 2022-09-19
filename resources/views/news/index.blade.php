@extends('layouts.app')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold">Новости всех категорий</h4>
    <div class="" id="news-content">
        @include('news.news-block')
    </div>
    <input type="hidden" id="count-of-news" value="{{ $count }}">
    <input type="hidden" id="show-more-url" value="{{ route('news.index') }}">
    <button class="btn btn-sm btn-light border-dark" id="showMore">
        <i class="la la-edit font-small-3 mr-25"></i>Показать еще
    </button>
    <div class="d-none" id="hidden-message"><h5 type="hidden">Больше нет записей</h5></div>
@endsection
