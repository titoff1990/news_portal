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
            <h3 class="text-center">Добавление новости</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
                @csrf

                <label for="image">Картинка для новости</label>
                <input type="file" class="form-control-file" id="image" name="image">

                <label for="name">Заголовок</label>
                <input type ="text" name="name" id="name" class="form-control mt-2 mb-2" value="{{ old('name') }}">
                <label for="content">Содержание</label>
                <textarea type ="text" name="content" id="content" class="form-control mt-2 mb-2"></textarea>
                <label for="name">Выберите категорию</label>
                <select name="category_id" class="input-group form-control mb-1">
                    <option value="0">Без категории</option>
                    @foreach($arrayOfCategories as $category)
                        <option value="{{ $category->getKey() }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="name">Теги</label>
                <input type ="text" name="tags" id="tags" class="form-control mt-2 mb-2" placeholder="Введите теги через запятую" value="{{ old('name') }}">
                <button type="submit" class="btn btn-primary mt-2">Добавить новость</button>
            </form>
        </div>
        <div class="card-footer text-muted text-center">
            Добавление новости
        </div>
    </div>
@endsection()
