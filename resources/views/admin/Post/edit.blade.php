@extends('admin.layout')

@section('title')
    Sửa post
@endsection
@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                               href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a href="{{url('admin.post.index')}}" class="opacity-5 text-white>"></a>post</li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Sửa Post</h6>
@endsection
@section('content')

    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Sửa post</h6>
        </div>
        @can('edit-post')
            <form action="{{url('admin/post/update/'. $post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body px-3 pt-2 pb-2">
                    <div class="form-group">
                        <label for="exampleName">Title</label>
                        <input type="text" class="form-control" id="slug" onkeyup="ChangeToSlug();"
                               value="{{$post->title}}" name="title">
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Slug</label>
                        <input type="text" class="form-control"
                              value="{{$post->slug}}" name="slug" id="convert_slug">
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName"> Category</label>
                        <select class="select2" name="category_id[]" multiple="multiple"
                                style="width: 100%">
                            @foreach ($categories as $category)
                                <option
                                    @if(in_array($category->id, $selectedID))
                                        selected
                                    @endif
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName"> Group</label>
                        <select class="select2" name="group_id"
                                style="width: 100%">
                            @foreach ($groups as $item)
                                <option
                                    @if($post->group_id == $item->id)
                                        selected
                                    @endif
                                    value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('group_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <img style="width:20%; object-fit: cover;" src="{{asset('storage/image/'. $post->avatar)}}" alt="anh">
                        <br>
                        <label for="exampleName">Avatar</label>
                        <input type="file" value="{{$post->avatar}}" class="form-control" id="exampleInputName"
                          name="avatar">
                        @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Landing</label>
                        <select class="form-control" id="exampleInputName" name="is_landing">
                           @if($post->is_landing == 1)
                               <option value="1" selected>Có</option>
                               <option value="0">Không có</option>
                            @else
                                <option value="0" selected>Không có</option>
                                <option value="1">Có</option>
                           @endif
                        </select>
                        @error('is_landing')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Tag</label>
                        <input type="text" class="form-control" id="exampleInputName"
                              value="{{$post->tags}}" name="tags">
                        @error('tags')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Mô tả ngắn</label>
                        <input type="text" class="form-control" id="exampleInputName"
                              value="{{$post->short_description}}" name="short_description">
                        @error('shot_description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Content</label>
                        <input type="text" class="form-control editor" id="exampleInputName"
                               value="{{ $post->content }}" name="content">
                        @error('content')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputName"
                               hidden="" name="user_id" value="{{Auth::user()->id}}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        @endcan
    </div>

@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('.tag_multiple').select2({
                theme: "classic",
                tags: true,
            });
        });
    </script>
@endsection
