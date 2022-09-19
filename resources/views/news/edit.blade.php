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
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow rounded-sm mt-3 mb-4 w-50 border-light">
        <div class="card-header">
            <h3 class="text-center">Редактирование новости</h3>
            <img class="card-img-top img-fluid" src="{{ asset(Storage::url($news->image)) }}" alt="Card image cap">
        </div>
        <div class="card-body">
            <form action="{{ route('news.update', $news->getKey()) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <label for="image">Выбрать новую картинку для новости</label>
                <input type="file" class="form-control-file" id="image" name="image" value="{{ $news?->image }}">
                <label for="name">Заголовок</label>
                <input type ="text" name="name" id="name" class="form-control mt-2 mb-2" value="{{ $news->name }}">
                <label for="content">Содержание</label>
                <textarea type ="text" name="content" id="content" class="form-control mt-2 mb-2">{{ $news->content }}</textarea>
                <label for="name">Категория</label>
                <select name="category_id" class="input-group form-control mb-1">
                    <option name="category_id" value="{{$news->category?->getKey() ?? 0}}">{{$news->category?->name ?? 'Без категории'}}</option>
                    @foreach($arrayOfCategories as $category)
                        <option value="{{ $category->getKey() }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="name">Теги</label>
                <input type ="text" name="tags" id="tags" class="form-control mt-2 mb-2" placeholder="Введите теги через запятую" value="{{ implode(', ', $arrayOfTags) }}">
                <button type="submit" class="btn btn-primary mt-2">Сохранить изменения</button>
            </form>
        </div>
        <div class="card-footer text-muted text-center">
            Редактирование новости
        </div>
    </div>
@endsection

