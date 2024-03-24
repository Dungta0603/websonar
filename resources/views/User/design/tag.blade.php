@extends('user.layout')


@section('title')
    Tag: {{$key}}
@endsection
@section('content')

    <div class= "my-20">
        <nav aria-label="breadcrumb breadcrumb-admin ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$key}}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-8">
                <div class="tag-lable my-6 mx-6">
                    <span>
                        #
                    </span>
                    <h1>{{$key}}</h1>
                </div>
                <div class="tag-post ms-2">
                    <div class="row">
                        @foreach($tags as $tag)
                            <div class="col-md-4 ">
                                <a href="{{url('detail/'. $tag->slug)}}">
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="{{asset('storage/image/' . $tag->avatar)}}" alt="{{$tag->title}}">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{url('detail/'. $tag->slug)}}">
                                <h3 style="font-size: 18px;">{{$tag->title}}</h3>
                                <strong style="font-size: 13px; color:black;">{{$tag->user->name}}</strong>
                                <p style="font-size: 15px; color:black;">{{$tag->short_description}}</p>
                                </a>
                            </div>
                        <hr class="my-6">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3 ms-5">
                <div class="banner-ads position-sticky top-10 ">
                    <img style="object-fit: cover; " src="{{asset('image/banner-3.jpg')}}" alt="banner">
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
