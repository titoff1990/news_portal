<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     * @throws ValidationException
     */
    public function store(Request $request): string
    {
        $key = $request->input('key');
        $this->validate($request, [
            'content' => ['max:1000'],
        ]);

        $comment = Comment::make([
            'content' => $request->input('content'),
            'news_id' => $key,
        ]);

        if ($comment->save()) {
            $news = News::find($key);
            $countOfComments = $news->getCountOfComments();
            $news->comments_count = ++$countOfComments;
            $news->save();
        }
        $news = News::find($key);
        $comments = $news->comments;


        return View::make('news.comments')->with(compact(['comments']))->render();

    }

}
