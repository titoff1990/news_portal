<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param News $news
     * @param Request $request
     * @return string|view
     */
    public function index(News $news, Request $request): string|view
    {
        // https://github.com/spatie/laravel-tags для тегов можно использовать готовое решение
        $categories = Category::all();
        $tags = Tag::all();
        // Отсортированный список новостей по количеству комментариев
        $sortedNews = $news->orderBy('comments_count', 'desc')->paginate(2);
        // Количество записей в таблице
        $countOfNews = $news->count();
        $count = count($sortedNews);
        $arrayOfPopularTags = [];
        // Формируем массив уникальных тегов у популярных новостей
        foreach($sortedNews as $item) {
            foreach ($item->tags as $itemTag) {
                // Можно ограничить количество отображаемых тегов
                if(count($arrayOfPopularTags) == 3) break;
                if (!in_array($itemTag, $arrayOfPopularTags)) {
                    $arrayOfPopularTags[] = $itemTag;
                }
            }
        }

        if ($request->ajax()) {
            $count = $request->input('count');
            $sortedNews = $news->orderBy('comments_count', 'desc')->skip($count)->take(1)->get();
            $count = $count + 1;
            $view = view('news.news-block', compact('sortedNews', 'count'))->render();

            return json_encode( ['html'=> $view, 'count' => $count]);
        }

        return view('news.index', compact([
            'sortedNews',
            'categories',
            'tags',
            'arrayOfPopularTags',
            'countOfNews',
            'count'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $arrayOfCategories = Category::all();

        return view('news.create', compact('arrayOfCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $inputTags = $request->input('tags');

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);
        $file = $request->file('image');
        $path = '';
        if (!empty($file)){
            $path = $file->store('public/images');
        }
        $news = News::make([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'image' => $path,
        ]);

        if ($news->save()) {
            if (!empty($inputTags)) {
                $inputTags = preg_replace('/^([ ]+)|([ ]){2,}/m', '$2', $inputTags);
                $arrTags = explode(',', trim($inputTags));
                $arrayTags = array_filter($arrTags, function($element) {
                    return !empty($element);
                });
                if (!empty($arrayTags)) {
                    foreach ($arrayTags as $item) {
                        $item = trim($item);
                        if (Tag::where('title','=', $item)->exists()) {
                            $existTags = Tag::where('title','=', $item)->get();
                            foreach($existTags as $existTag) {
                                $news->tags()->attach($existTag);
                            }
                        } else {
                            $tag = Tag::make([
                                'title' => $item,
                            ]);
                            $tag->save();
                            $news->tags()->attach($tag);
                        }
                    }
                }
            }
            Session::flash('success', __('news.news_store_success'));
            return redirect()->route('news.index', $news->getKey());
        }
        Session::flash('error', __('news.news_store_error'));
        return redirect()->route('news.create')->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(News $news, Request $request): View|Factory|Application
    {
        $comments = $news->comments;

        return view('news.show', compact('news', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return Application|Factory|View
     */
    public function edit(News $news): View|Factory|Application
    {
        $arrayOfCategories = Category::all();
        $newsTags = $news?->tags;
        $arrayOfTags = [];
        foreach($newsTags as $item){
            $arrayOfTags[] = $item->title;
        }

        return view('news.edit', compact('news', 'arrayOfCategories', 'arrayOfTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param News $news
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $inputTags = $request->input('tags');
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $file = $request->file('image');

        $news->forceFill([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
        ]);
        if (!empty($file)){
            $path = $file->store('public/images');
            $news->image = $path;
        }
        $save = $news->save();

        if ($save) {
            if (!empty($inputTags)) {
                $inputTags = preg_replace('/^([ ]+)|([ ]){2,}/m', '$2', $inputTags);
                $arrTags = explode(',', trim($inputTags));
                $arrayTags = array_filter($arrTags, function($element) {
                    return !empty($element);
                });
                if (!empty($arrayTags)) {
                    foreach ($arrayTags as $item) {
                        $item = trim($item);
                        if (Tag::where('title', $item)->exists()) {
                            $existTags = Tag::where('title', $item)->get();
                            foreach($existTags as $existTag) {
                                $arr = [];
                                foreach ($news->tags as $tag) {
                                    $arr[] = $tag->title;
                                }
                                if (!in_array($item, $arr)) {
                                    $news->tags()->attach($existTag);
                                }
                            }
                        } else {
                            $tag = Tag::make([
                                'title' => $item,
                            ]);
                            $tag->save();
                            $news->tags()->attach($tag);
                        }
                    }
                }
            }
            Session::flash('success', __('news.news_update_success'));
            return redirect()->route('news.edit', $news->getKey());
        }
        Session::flash('error', __('news.news_store_error'));
        return redirect()->route('news.edit')->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return RedirectResponse
     */
    public function destroy(News $news): RedirectResponse
    {
        $news?->delete();
        Session::flash('success', __('news.news_delete'));
        return redirect()->route('news.index');
    }
}
