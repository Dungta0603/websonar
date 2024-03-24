@if(count((array)$comments) > 0)
    @foreach ($comments as $comment)
            <div class="comment">
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
                        <span class="reply-comment-data"  data-id="{{$comment->id}}" style="cursor: pointer" class="mt-2">
                                                                                    <i class="ri-chat-1-line"></i>
                                                                                    Trả lời
                                                                                </span>
                        @can('delete-comment')
                            <span class="ms-2 mt-2" data-id="{{$comment->id}}" style="cursor: pointer"  onclick="deleteComment(this)">
                                                                                        <i class="ri-delete-bin-line"></i>
                                                                                        Xóa Comment
                                                                                    </span>
                        @endcan
                    </div>
                </div>
                <div class="card-footer py-5 border-0 mt-6 mb-16 create-comment form-reply-{{$comment->id}}" style="background-color: #f8f9fa;">
                    <div class="d-flex flex-start w-100">
                        <div class="form-outline w-100">
                            <input hidden="hidden" class="post-id-{{$comment->id}}" data-id="{{$comment->id}}" type="text" value="{{$post->id}}">
                            <input hidden="hidden" class="parent-id-{{$comment->id}}" data-id="{{$comment->id}}" type="text" value="{{$comment->id}}">
                            <input hidden="hidden" class="user-id-{{$comment->id}}" data-id="{{$comment->id}}" type="text" value="{{\Illuminate\Support\Facades\Auth::user()->id}}" >
                            <textarea  class="form-control content textAreaExample-{{$comment->id}}"   data-id="{{$comment->id}}" rows="4"
                                       style="background: #fff;"></textarea>
                            <label class="form-label" for="textAreaExample">Lời bình luận</label>
                        </div>
                    </div>
                    <div class="float-end mt-2 pt-3">
                        <button  type="button" class="btn btn-primary btn-sm post-comment" data-id="{{$comment->id}}">Đăng</button>
                        <button type="button" data-id="{{$comment->id}}" class="btn btn-outline-primary btn-sm cancel-form-{{$comment->id}} cancel-form">Cancel</button>
                    </div>
                </div>
            </div>
            <hr>

            @if(count((array)$comment->replies) > 0)
                <div class="ms-5">
                    @include('user.design.comment',['comments'=> $comment->replies])
                </div>
            @endif


    @endforeach
@endif
