@extends('user.layout')


@section('title')
    Chi tiết {{\Illuminate\Support\Str::of($post->title)->words(6)}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 my-6 left">
            <nav aria-label="breadcrumb breadcrumb-admin ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">
                        @foreach($post->categories as $category)
                            <a href="{{url('category/' . $category->slug)}}">{{$category->name}}</a>
                        @endforeach
                    </li>
                </ol>
            </nav>
            <div class="detail-main-content mt-3 ms-3">
                <div class="detail-main-content-title">
                    <h2> {{$post->title}}</h2>
                </div>
                <div class="detail-main-content-author">
                    <p style="color: red">{{$post->user->name}}</p>
                </div>
                <hr>

                <div class="detail-content mb-6">
                    {!! $post->content !!}
                </div>

                <div class="detail-tags mb-9">
                        <span>
                            <i class="ri-price-tag-3-line text-xl-start"></i>
                            <span>Tags</span>
                        </span>
                    <br>
                    <br>
                    @if(!(empty($post->tags)))
                        @php
                            $tags = [];
                            $tags = explode(',', $post->tags);
                        @endphp
                        @foreach($tags as $key=>$tag)
                            <a class="tag-link" href="{{url('tag/'.$tag)}}" class="me-2">{{$tag}}</a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="bottom-detail ms-3 mt-8">
                <div class="comment-detail position-relative">
                    <div class="comment-title position-relative ms-4 mb-3">
                        <h3 class="mb-3">Để lại bình luận của bạn</h3>
                        <section>
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <button id="btn-comment" class="btn btn-primary">
                                    <i class="ri-add-line me-1"></i>
                                    Bình luận ngay
                                </button>
                                <div class="card-footer py-5 border-0 mt-6 mb-16 create-comment"
                                     style="background-color: #f8f9fa;">
                                    <div class="d-flex flex-start w-100">
                                        <div class="form-outline w-100">
                                            <input hidden="hidden" id="post-id" type="text" value="{{$post->id}}">
                                            <input hidden="hidden" id="user-id" type="text"
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                            <textarea class="form-control" id="textAreaExample" rows="4"
                                                      style="background: #fff;"></textarea>
                                            <label class="form-label" for="textAreaExample">Lời bình luận</label>
                                        </div>
                                    </div>
                                    <div class="float-end mt-2 pt-3">
                                        <button id="post-comment" type="button" class="btn btn-primary btn-sm">Đăng
                                        </button>
                                        <button id="cancel-comment" type="button"
                                                class="btn btn-outline-primary btn-sm">Cancel
                                        </button>
                                    </div>
                                </div>
                            @else
                                <button class="btn btn-primary" onclick="createErrorToast('Bạn cần phải đăng nhập')">
                                    Bình luận ngay
                                </button>
                            @endif
                            <div class="my-5 py-5 show-comment" style="background-color: #f8f9fa;">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-lg-10">
                                        <div class="card text-dark">
                                            <div class="card-body p-4">
                                                <h4 class="mb-0">Bình luận về bài viết</h4>
                                                <p class="fw-light mb-4 pb-2">Bình luận mới nhất</p>
                                                <div class="ms-5 ">
                                                    @if(count((array)$post->comments))
                                                        @foreach($post->comments as $comment)
                                                            @if($comment->parent_id == 0)
                                                                <div id="hide-comment">
                                                                <div class="mt-3">
                                                                    <div>
                                                                        <h6 class="fw-bold mb-1">{{$comment->user->name}}</h6>
                                                                        <div class="d-flex align-items-center mb-3">
                                                                            <p class="mb-0">
                                                                                {{ date('d-m-Y'), strtotime($comment->created_at) }}
                                                                            </p>
                                                                        </div>
                                                                        <p class="mb-2">
                                                                            {{$comment->content}}
                                                                        </p>
                                                                        <span class="reply-comment-data"
                                                                              data-id="{{$comment->id}}"
                                                                              style="cursor: pointer" class="mt-2">
                                                                                <i class="ri-chat-1-line"></i>
                                                                                Trả lời
                                                                            </span>
                                                                        @can('delete-comment')
                                                                            <span class="ms-2 mt-2"
                                                                                  data-id="{{$comment->id}}"
                                                                                  style="cursor: pointer"
                                                                                  onclick="deleteComment(this)">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                    Xóa Comment
                                                                                </span>
                                                                        @endcan

                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="card-footer py-5 border-0 mt-6 mb-16 create-comment form-reply-{{$comment->id}}"
                                                                    style="background-color: #f8f9fa;">
                                                                    <div class="d-flex flex-start w-100">
                                                                        <div class="form-outline w-100">
                                                                            <input hidden="hidden"
                                                                                   class="post-id-{{$comment->id}}"
                                                                                   data-id="{{$comment->id}}"
                                                                                   type="text" value="{{$post->id}}">
                                                                            <input hidden="hidden"
                                                                                   class="parent-id-{{$comment->id}}"
                                                                                   data-id="{{$comment->id}}"
                                                                                   type="text" value="{{$comment->id}}">
                                                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                                                <input hidden="hidden"
                                                                                       class="user-id-{{$comment->id}}"
                                                                                       data-id="{{$comment->id}}"
                                                                                       type="text"
                                                                                       value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                                                            @endif

                                                                            <textarea
                                                                                class="form-control textAreaExample-{{$comment->id}}"
                                                                                data-id="{{$comment->id}}" rows="4"
                                                                                style="background: #fff;"></textarea>
                                                                            <label class="form-label"
                                                                                   for="textAreaExample">Lời bình
                                                                                luận</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="float-end mt-2 pt-3">
                                                                        <button type="button"
                                                                                class="btn btn-primary btn-sm post-comment"
                                                                                data-id="{{$comment->id}}">Đăng
                                                                        </button>
                                                                        <button type="button" data-id="{{$comment->id}}"
                                                                                class="btn btn-outline-primary btn-sm cancel-form-{{$comment->id}} cancel-form">
                                                                            Cancel
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                </div>
                                                                <div class="ms-5" id="commentShow">
                                                                    @if(count((array)$comment->replies) > 0)
                                                                        @include('user.design.comment',['comments'=> $comment->replies, 'commentID'=> $comment->id])
                                                                    @endif
                                                                </div>
                                                            @endif

                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </div>


        @endsection

        @section('banner')
            <div class="col-md-3 my-6 ms-12 ">
                <div class="banner-ads right hide-mobile" style="min-height: 800px;">
                    <img class="mb-2" style="object-fit: cover; " src="{{asset('image/banner.png')}}" alt="banner">
                    <img class="my-2" style="object-fit: cover; " src="{{asset('image/banner-2.png')}}" alt="banner">
                    <img class="my-2 position-sticky overflow-hidden top-10" style="object-fit: cover; "
                         src="{{asset('image/banner-1.gif')}}" alt="banner">
                </div>
            </div>
    </div>

@endsection
@section('javascript')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        $('#post-comment').click(function (ev) {
            ev.preventDefault();
            let content = $('#textAreaExample').val();
            let postID = $('#post-id').val();
            let userID = $('#user-id').val();
            let _csrf = '{{ csrf_token() }}';
            if (content.length > 0) {
                $.ajax({
                    url: "http://127.0.0.1:8000/comment/store",
                    type: "POST",
                    data: {
                        post_id: postID,
                        user_id: userID,
                        content: content,
                        _token: _csrf
                    },
                    success: function (response) {
                        createSuccessToast('Đã bình luận')
                        $('#commentShow').html(response);
                        $('#textAreaExample').val('');
                        $('.create-comment').slideUp();
                    }
                });
            } else {
                createErrorToast('Không được để trống bình luận');
            }

        });

        function deleteComment(element) {
            let commentId = $(element).data('id');

            $.ajax({
                url: `http://127.0.0.1:8000/comment/delete/${commentId}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function (data) {
                    createSuccessToast('Đã xóa bình luận')
                    $('#commentShow').html(data);
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }

        $('.btn-reply-comment').click(function (ev) {
            ev.preventDefault();
            let id = $(this).data('id');
        });

        $(document).on('click', '.reply-comment-data', function (ev) {
            ev.preventDefault();
            let id = $(this).data('id');
            let formReply = '.form-reply-' + id;
            $('.create-comment').slideUp();

            $(formReply).slideDown();


        });

        $(document).on('click', '.cancel-form', function (ev) {
            ev.preventDefault();
            let id = $(this).data('id');
            let formCancel = '.form-reply-' + id;
            $(formCancel).slideUp();
        });

        $(document).on('click', '.post-comment', function (ev) {
            ev.preventDefault();
            let id = $(this).data('id');
            let commentReplyId = '.textAreaExample-' + id;
            let commentReply = $(commentReplyId).val();
            let postReplyID = '.post-id-' + id;
            let postReply = $(postReplyID).val();
            let userReplyID = '.user-id-' + id;
            let userReply = $(userReplyID).val();
            let parentReplyID = '.parent-id-' + id;
            let parentReply = $(parentReplyID).val();
            let _csrf = '{{ csrf_token() }}';
            if (commentReply.length > 0) {
                $.ajax({
                    url: "http://127.0.0.1:8000/comment/store",
                    type: "POST",
                    data: {
                        post_id: postReply,
                        user_id: userReply,
                        content: commentReply,
                        parent_id: parentReply,
                        _token: _csrf,
                    },
                    success: function (response) {
                        createSuccessToast('Đã bình luận')
                        $('#commentShow').html(response);
                        $('.content').val('');
                        $('#hide-comment').val('');
                        $('.create-comment').slideUp();
                    }
                });
            } else {
                createErrorToast('Không được để trống bình luận');
            }
        });
    </script>
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // Lấy chiều cao của layout left
            var leftElement = document.querySelector(".left");
            var leftHeight = leftElement.offsetHeight;

            // Gán chiều cao của layout left cho layout right
            var rightElement = document.querySelector(".right");
            rightElement.style.height = leftHeight + "px";

            // Đảm bảo rằng chiều cao của layout right sẽ được cập nhật khi kích thước trình duyệt thay đổi
            window.addEventListener("resize", function () {
                leftHeight = leftElement.offsetHeight;
                rightElement.style.height = leftHeight + "px";
            });
        });


        let BASE_URL = 'http://127.0.0.1:8000';
        let btnComment = document.querySelector('#btn-comment');
        btnComment.addEventListener('click', () => {
            let createComment = document.querySelector('.create-comment');
            createComment.classList.toggle('active');
        });

        let cancelComment = document.querySelector('#cancel-comment');

        cancelComment.addEventListener('click', () => {
            let createComment = document.querySelector('.create-comment');
            createComment.classList.remove('active');
            textAreaExample.value = '';
        })
    </script>

@endsection
