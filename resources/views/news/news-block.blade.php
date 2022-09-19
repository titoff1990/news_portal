@foreach($sortedNews as $elem)
    <div class="card shadow rounded-sm mt-2 mb-2 w-50 coll-lg-12 border-light">
        <img class="card-img-top img-fluid" src="{{ asset(Storage::url($elem->image)) }}" alt="Card image cap">
        <div class="card-body">
            <h3 class=""><a href="{{ route('news.show', $elem->getKey()) }}" class="link-secondary page-link" data-toggle="tooltip" data-placement="top" title="Открыть новость">{{ $elem->name }}</a></h3>
            <p class="card-text">{{ Str::limit($elem->content, 300, '...' )}}</p>
        </div>
        @auth
            <div class="card-footer">
                <div class="input-group">
                    <div class="form-control-sm">
                        <a class="btn btn-sm btn-outline-info" href="{{ route('news.edit', $elem->getKey()) }}">
                            <i class="la la-edit font-small-3 mr-25"></i>Редактировать
                        </a>
                    </div>
                    <form method="POST" action="{{ route('news.destroy', $elem->getKey()) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="ap btn btn-sm btn-outline-info mt-1" value="Удалить">
                    </form>
                </div>
            </div>
        @endauth
    </div>
    <br>
@endforeach
