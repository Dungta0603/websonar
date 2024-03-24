@extends('user.layout')

@section('title')
    Trang chủ
@endsection
@section('content')

        <div class="row">
            <div class="col-md-8 col-sm-12 my-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-content">
                            @foreach(\App\Models\Admin\Post::where('is_landing', 1)->limit(1)->latest()->get() as $post)
                                <a href="{{url('detail/'. $post->slug)}}" class="link-title-content">
                                    <img class="image-title" src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                    <h5 class="title-content">{{$post->title}}</h5>
                                </a>
                            @endforeach
                        </div>
                        <div class="row">
                            @foreach($relatedPosts as $post)
                                <div class="col-md-6 col-sm-6 category-movie">
                                    <a href="{{url('detail/'. $post->slug)}}" class="link-title-content">
                                        <img class="image-title" src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                        <h5 class="title-content title-content-main">{{$post->title}}</h5>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-lg-12 right-content-main">
                                @foreach($rightRandomPost as $post)
                                    <div>
                                        <a href="{{url('detail/' . $post->slug)}}" class="link-title-content">
                                            <img src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                            <h5 class="title-content title-content-main">
                                                {{$post->title}}
                                            </h5>
                                        </a>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-3 my-6 ms-12 hide-mobile" >
                    <div class="banner-ads position-sticky top-10 " style="background: #e7e7e7; max-height: 800px;">
                        <img style="object-fit: cover; " src="{{asset('image/banner.png')}}" alt="banner">
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-md-12 pe-8">
                @foreach(\App\Models\Admin\Group::all() as $group)
                    <div class="mb-4 mt-3">
                        <p class="text-bold text-sm text-horizon">{{$group->name}}</p>
                    </div>
                    <div class="row mt-10">
                        @foreach($group->posts as $post)
                            <div class="col-md-3 notable">
                                <a href="{{url('detail/' . $post->slug)}}" class="link-title-content">
                                    <img class="image-title" src="{{asset('storage/image/' . $post->avatar)}}" alt="ảnh content">
                                    <h5 class=" title-content title-content-main ">{{$post->title}}</h5>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
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
                <img class="my-2 ms-11 position-sticky overflow-hidden top-10 hide-mobile" style="object-fit: cover; " src="{{asset('image/banner-1.gif')}}" alt="banner">
            </div>
        </div>
    </div>
@endsection
