<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->input('search');
        $news = News::where('name', 'ILIKE', "%$input%")->get();
        $categories = Category::where('name', 'ILIKE', "%$input%")->get();

        return view('news.search', compact(['news', 'categories']));
    }
}
