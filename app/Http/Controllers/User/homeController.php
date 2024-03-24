<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Post;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $randomCategoryID = session('random_category');
        $rightRandomCategoryID = session('random_right_category');
        $CategoryIDs = Category::pluck('id')->all();
        $randomKey = array_rand($CategoryIDs);
        if (!$randomCategoryID || $randomCategoryID == $rightRandomCategoryID) {
            $randomCategoryID = $CategoryIDs[$randomKey];
            session(['random_category' => $randomCategoryID]);
        } elseif (!$rightRandomCategoryID) {
            $rightRandomCategoryID = $CategoryIDs[$randomKey];
            session(['random_right_category' => $rightRandomCategoryID]);
        }
        $relatedPosts = Post::whereHas('categories', function ($query) use ($randomCategoryID) {
            $query->where('category_id', $randomCategoryID);
        })->where('is_landing', 0)->where('status', 1)->limit(2)->latest()->get();

        $rightRandomPost = Post::whereHas('categories', function ($query) use ($rightRandomCategoryID) {
            $query->where('category_id', $rightRandomCategoryID);
        })->where('is_landing', 0)->where('status', 1)->limit(3)->latest()->get();

        return view('user.design.home', compact('relatedPosts', 'rightRandomPost'));
    }

    public function detail($slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $post = Post::where('slug', $slug)->where('status', 1)->first();
        return  view('user.design.detail', compact('post'));
    }

    public function category($slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts;
        return view('user.design.category', compact('category', 'posts'));
    }

    public function tag($tag): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $key = $tag;
        $tags = Post::where('tags', 'LIKE', '%' . $tag . '%')->where('status', 1)->get();
        $post = Post::where('tags', 'LIKE', '%' . $tag . '%')->where('status', 1)->first();

        return view('user.design.tag', compact('tags', 'key'));
    }

    public function searchPage(Request $request)
    {

        $key = $request->search;
        $searches = Post::where([
            ['title' ,'!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->search)) {
                    $query->Where('title', 'LIKE', '%' . $s . '%')->where('status' , 1)->get();
                }
            }]
        ])->paginate(12);
        $searches->appends(['key' => $key]);


        return view('user.design.search',compact('searches','key'));
    }

    public function searchAPI(Request $request): \Illuminate\Http\JsonResponse
    {
        $searches = Post::where('title', 'like', '%' . $request->key . '%')->where('status', 1)->limit(5)->latest()->get();

        return response()->json([
            'results' => $searches,
            'status' => 'success',
        ]);
    }
}
