@extends('admin.layout')

@section('title')
    Sửa Category
@endsection
@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                               href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a href="{{url('admin.category.index')}}" class="opacity-5 text-white>"></a>Category</li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Sửa Category</h6>
@endsection
@section('content')

    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Sửa Category</h6>
        </div>
        @can('edit-category')
            <form action="{{url('admin/category/update/' . $category->id)}}" method="POST">
                @csrf
                <div class="card-body px-3 pt-2 pb-2">
                    <div class="form-group">
                        <label for="exampleName">Tên Category</label>
                        <input type="text" class="form-control" id="slug" onkeyup="ChangeToSlug();"
                             value="{{$category->name}}" name="name">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Slug</label>
                        <input type="text" class="form-control"
                               value="{{$category->slug}}" name="slug" id="convert_slug">
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleName">Parent</label>
                        <select class="select2" name="parent_id"
                                style="width: 100%">
                            <option value="0">None</option>
                            @foreach ($categories as $item)
                                @if ($category->parent_id == 0)
                                <option
                                    @if($category->parent_id == $item->id)
                                        selected
                                    @endif
                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('parent_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
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
        $(document).ready(functiNcateon() {
            $('.select2').select2();

            $('.tag_multiple').select2({
                theme: "classic",
                tags: true,
            });
        });
    </script>
@endsection
