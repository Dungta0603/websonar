@extends('admin.layout')

@section('title')
    Trang Post
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                               href="javascript:;">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Post</li>
    </ol>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Post Table</h6>
            <div class="mb-4 mt-4">

                   <a class="btn bg-gradient-dark mb-0" href="{{url('admin/post/create')}}"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Thêm Post</a>

                    <a class="btn bg-gradient-dark mb-0 ms-2" href="{{url('admin/post/restore')}}"><i class="ri-restart-line" aria-hidden="true"></i>&nbsp;&nbsp;Restore Post</a>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Ảnh đại diện</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2 opacity-7 ">Title</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Tác giả</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder  opacity-7">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                <p class="text-xs text-center  mb-0" style="width:38%" >{{$post->id}}</p>
                            </td>
                            <td>
                                <img style="object-fit: cover; width: 100px; height: 100px;" src="{{asset('storage/image/' .$post->avatar)}}" alt="{{$post->title}}">
                            </td>
                            <td>
                                <p class="text-xs mb-0" >{{Illuminate\Support\Str::of($post->title)->words(10)}}</p>
                            </td>
                            <td>
                                <p class="text-xs text-center  mb-0">{{$post->user->name}}</p>
                            </td>
                            <td>
                                @foreach($post->categories as $category)
                                <p class="text-xs mb-0">{{$category->name}} , </p>
                                @endforeach
                            </td>
                            <td class="align-middle text-center ms-auto text-end">
                               @can('delete', $post)
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" onclick="return confirmation(this)" href="{{url('admin/post/destroy/'. $post->id)}}" ><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</a>
                                @endcan
                                @can('update', $post)
                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{url('admin/post/edit/'. $post->id)}}"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                                   @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{$posts->links('vendor.pagination.bootstrap-4')}}

@endsection

@section('javascript')
    <script>
        function confirmation(eve) {
            let url = eve.getAttribute('href');
            console.log(url);
           swal({
              title: 'Bạn có chắc là xóa nó chứ?',
              text: 'Bạn có thể restore nó',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
           })
               .then((willCancle)=>{
                   if (willCancle) {
                       window.location.href = url;
                   }
               })
        return false;
        }
    </script>
@endsection
