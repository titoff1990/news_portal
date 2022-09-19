@extends('layouts.app')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <h4 class="fw-bold">Категории</h4>
        @foreach($categories as $item)
            <div class="card shadow rounded-sm mt-3 mb-4 w-50 border-light">
                <div class="card-body">
                    <h3 class=""><a class="page-link link-info" href="{{ route('category.show', $item)}}">{{ $item->name }}</a></h3>
                    <p class="card-text">{{ $item->content }}</p>
                </div>
                @auth
                    <div class="card-footer">
                        <a class="btn btn-sm btn-outline-info" href="{{ route('category.edit', $item->getKey()) }}">
                            <i class="la la-edit font-small-3 mr-25"></i>Редактировать
                        </a>
                        <form method="POST" action="{{ route('category.destroy', $item->getKey()) }}">
                            @method('DELETE')
                            @csrf
                            <input type="submit" class="ap btn btn-sm btn-outline-info mt-1" value="Удалить">
                        </form>
                    </div>
                @endauth
            </div>
        @endforeach
    </div>
@endsection
