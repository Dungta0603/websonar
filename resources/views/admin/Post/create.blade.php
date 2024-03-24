@extends('admin.layout')

@section('title')
    Thêm Post
@endsection
@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                               href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a
                href="{{url('admin.post.index')}}" class="opacity-5 text-white>"></a>Post
        </li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Thêm Post</h6>
@endsection
@section('content')

    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Thêm post</h6>
        </div>
        @can('create-post')
            <form action="{{url('admin/post/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="card-body px-3 pt-2 pb-2">
                    <div class="form-group">
                        <label for="exampleName">Title</label>
                        <input type="text" class="form-control" id="slug" onkeyup="ChangeToSlug();"
                               placeholder="Tiêu đề" name="title">
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Slug</label>
                        <input type="text" class="form-control"
                               placeholder="slug" name="slug" id="convert_slug">
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName"> Category</label>
                        <select class="select2" name="category_id[]" multiple="multiple"
                                style="width: 100%">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('group_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Avatar</label>
                        <input type="file" class="form-control" id="exampleInputName"
                               placeholder="Link ảnh" name="avatar">
                        @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Tag</label>
                        <input type="text" class="form-control" id="exampleInputName"
                               placeholder="tag" name="tags">
                        @error('tags')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Landing</label>
                        <select class="form-control" id="exampleInputName" name="is_landing">
                            <option value="0">Không có</option>
                            <option value="1">Có</option>
                        </select>
                        @error('is_landing')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Mô tả ngắn</label>
                        <input type="text" class="form-control" id="exampleInputName"
                               placeholder="Mô tả ngắn" name="short_description">
                        @error('short_description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Content</label>
                        <textarea type="text" class="form-control editor" id="exampleInputName"
                               placeholder="Thêm content" name="content"></textarea>
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

        ClassicEditor
            .create( document.querySelector( '.editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
