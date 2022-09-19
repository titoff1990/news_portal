@extends('layouts.app')
@section('content')
    @if($news->isNotEmpty())
        @foreach($news as $item)
            <h5><a href="{{ route('news.show', $item->getKey()) }}">{{ $item->name }}</a></h5>
        @endforeach
    @endif
    @if($categories->isNotEmpty())
        @foreach($categories as $item)
            <h5><a href="{{ route('category.show', $item->id )}}">{{ $item->name }}</a></h5>
        @endforeach
    @endif
@endsection


