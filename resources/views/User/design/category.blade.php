@extends('user.layout')


@section('title')
    {{$category->name}} - Tin tức được cập nhật liên tục
@endsection

@section('content')
    <div class="category-page">
        <div class="category-children">
                <div class="category-children-item d-sm-flex gap-5 justify-content-start align-items-center">
                @if(\App\Models\Admin\Category::where('parent_id' , $category->id)->count() > 0)
                        <a href="{{url('category/'. $category->slug)}}" class="{{ request()->is('category/' .$category->slug) ? 'active' : '' }}">{{$category->name}}</a>
                @foreach(\App\Models\Admin\Category::where('parent_id' , $category->id)->get() as $category)
                    <a href="{{url('category/'. $category->slug)}}" class="{{ request()->is('category/' .$category->slug) ? 'active' : '' }}">{{$category->name}}</a>
                @endforeach
                @else
                    @if(\App\Models\Admin\Category::where('id', $category->parent_id)->count() > 0)
                    @foreach(\App\Models\Admin\Category::where('id', $category->parent_id)->get() as $item)
                            <a href="{{url('category/'. $item->slug)}}" class="{{ request()->is('category/'. $item->slug) ? 'active' : '' }}">{{$item->name}}</a>
                    @endforeach
                        @else
                            <a href="{{url('category/'. $category->slug)}}" class="{{ request()->is('category/'. $category->slug) ? 'active' : '' }}">{{$category->name}}</a>
                    @endif
                    @foreach(\App\Models\Admin\Category::where('parent_id', $category->parent_id)->where('parent_id', '!=', 0)->get() as $category)
                        <a href="{{url('category/'. $category->slug)}}" class="{{ request()->is('category/'. $category->slug) ? 'active' : '' }}">{{$category->name}}</a>
                    @endforeach
                @endif
            </div>
        </div>
        <div>
        <div class="row">
            <div class="col-sm-8">
                <div class="left-category mt-12">
                    <div class="row">
                        <div class="col-md-8">
                            @foreach($posts->where('status', 1)->where('is_landing', 1)->sortByDesc('created_at')->take(1) as $post)
                                    <div>
                                        <a href="{{url('detail/'. $post->slug)}}" class="link-title-content">
                                            <img class="image-title" src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                            <h5 class="title-content title-content-main">{{$post->title}}</h5>
                                        </a>
                                    </div>
                            @endforeach
                                <div class="left-category-children">
                                    <div class="row">
                                        @foreach($posts->where('status', 1)->sortByDesc('created_at')->take(2) as $post)
                                            <div class="col-sm-6">
                                                <a href="{{url('detail/'. $post->slug)}}" class="link-title-content">
                                                    <img class="image-title" src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                                    <h5 class="title-content title-content-main">{{$post->title}}</h5>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="right-category">
                            @foreach($posts->where('status', 1)->sortByDesc('created_at')->skip(2)->take(1) as $post)
                                <div>
                                    <img src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                    <h5 class="title-content title-content-main">
                                        {{$post->title}}
                                    </h5>
                                </div>
                                <hr>
                            @endforeach
                            <div class="row">
                                @foreach($posts->where('status', 1)->take(3) as $post)
                                    <div class="col-md-5">
                                        <img src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                    </div>
                                    <div class="col-md-7">
                                        <h6 style="font-size: 12px !important; margin-top: 3px !important;" class="title-content title-content-main">
                                            {{$post->title}}
                                        </h6>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                            <div>

                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <img style="margin-top: 45px;" class="ms-3 position-sticky overflow-hidden top-10" style="object-fit: cover; " src="{{asset('image/banner-1.gif')}}" alt="banner">
            </div>
        </div>

        </div>
    </div>
@endsection

@section('bottom-main')
    <div class="bottom-detail my-16">
        <div class="comment-detail position-relative">
            <div class="comment-title position-relative ms-4 mb-3">
                <h3 class="mb-3">Có thể bạn sẽ thích</h3>
            </div>
        </div>

        <div class="row my-6">
            <div class="col-sm-6">
                <div class="row" style="width: 97%">
                    @foreach(\App\Models\Admin\Post::where('status', 1)->get() as $post)
                        <div class="col-sm-6 my-6">
                            <a href="{{url('detail/'. $post->slug)}}">
                                <img class="object-fit-cover" src="{{asset('storage/image/' .$post->avatar)}}" alt="Ảnh" />
                            </a>
                        </div>
                        <div class="col-sm-6 my-6">

                            @foreach($post->categories as $category)
                                <a href="{{url('category'. $category->slug)}}" class="my-2 text-dark">{{$category->name}}</a>
                            @endforeach
                            <a href="{{url('detail/'. $post->slug)}}">
                                <h4>{{$post->title}}</h4>
                                <p class="my-2" style="font-size: 13px; color:black;">{{$post->short_description}}</p>
                            </a>
                        </div>
                        </a>
                        <hr>
                    @endforeach
                </div>

            </div>
            <div class="col-md-6 pe-7">
                @foreach(\App\Models\Admin\Category::get() as $category)
                    <div class="right-bottom-main my-6">
                        <div class="heading-right-bottom-main">
                            <a href="{{url('category/' . $category->slug)}}">{{$category->name}}</a>
                        </div>
                        <div class="row">
                            @foreach($category->posts->take(2)->sortByDesc('created_at') as $post)
                                <div class="col-md-5">
                                    <a href="{{url('detail/'. $post->slug)}}">
                                        <img src="{{asset('storage/image/' .$post->avatar )}}" alt="anh">
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <a href="{{url('detail/'. $post->slug)}}">
                                        <div>
                                            <h4>{{$post->title}}</h4>
                                            <p class="my-2" style="font-size: 13px; color:black;">{{$post->short_description}}</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="content-category-right"></div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <img class="my-2 ms-11 position-sticky overflow-hidden top-10" style="object-fit: cover; " src="{{asset('image/banner-1.gif')}}" alt="banner">
            </div>
        </div>
    </div>
@endsection
