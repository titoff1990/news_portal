@extends('layouts.app')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="fw-bold">Обсуждаемые темы</h4>
    @if(!empty($arrayOfPopularTags))
        @foreach($arrayOfPopularTags as $item)
            <div class="card shadow rounded-sm mt-3 mb-4 w-50 border-light">
                <div class="card-body">
                    <h3><a href="{{ route('tag.show', $item) }}" class="page-link link-info">{{ $item->title }}</a></h3>
                </div>
            </div>
        @endforeach
    @endif
@endsection
