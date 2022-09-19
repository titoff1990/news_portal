@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow rounded-sm mt-2 mb-2 w-50 coll-lg-12 border-light">
        <div class="card-header">
            <h3 class="text-center">Добавление категории</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('category.store') }}">
                @csrf
                <label for="name">Название категории</label>
                <input type ="text" name="name" id="name" class="form-control mt-2 mb-2" value="{{ old('name') }}">
                <button type="submit" class="btn btn-primary mt-2">Добавить категорию</button>
            </form>
        </div>
        <div class="card-footer text-muted text-center">
            Добавление категории
        </div>
    </div>
@endsection()
