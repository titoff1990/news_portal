@foreach($comments as $comment)
    <p class="px-2">{{ $comment->created_at->format('Y.m.d h:m:s') }}</p><p class="px-2">{{ $comment->content }}</p>
@endforeach
