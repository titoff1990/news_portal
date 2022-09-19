<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Tag $tag
     * @return Factory|\Illuminate\Contracts\View\View|Application
     */
    public function index(Tag $tag): Application|Factory|\Illuminate\Contracts\View\View
    {
        $popularNews = News::orderBy('comments_count', 'desc')->limit(3)->get();
        $tags = $tag->all();
        $arrayOfPopularTags = [];
        // Формируем массив уникальных тегов у популярных новостей
        foreach($popularNews as $item) {
            foreach ($item->tags as $itemTag) {
                // Можно ограничить количество отображаемых тегов
                if(count($arrayOfPopularTags) == 3) break;
                if (!in_array($itemTag, $arrayOfPopularTags)) {
                    $arrayOfPopularTags[] = $itemTag;
                }
            }
        }
        return view('tags.index', compact('tags', 'popularNews', 'arrayOfPopularTags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Tag $tags
     * @return string
     * @throws ValidationException
     */
    public function store(Request $request, Tag $tags): string
    {
        $this->validate($request, [
            'title' => ['max:1000'],
        ]);

        $tag = Tag::make([
            'title' => $request->input('title'),
        ]);
        $tag->save();
        $allTags = $tags->all();

        return View::make('tags.tags')->with(compact(['allTags']))->render();
    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\View|Application|Factory
     */
    public function show(Tag $tag): Application|Factory|\Illuminate\Contracts\View\View
    {
        $tagNews = $tag?->news;
        return view('tags.show', compact('tagNews', 'tag'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag?->delete();
        Session::flash('success', __('news.news_delete'));
        return redirect()->route('news.index');
    }
}
