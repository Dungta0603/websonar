@extends('admin.layout')

@section('title')
    Trang Category
@endsection

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                               href="javascript:;">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Category</li>
    </ol>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Category Table</h6>
            <div class="mb-4 mt-4">
                @can('create-category')
                    <a class="btn bg-gradient-dark mb-0" href="{{url('admin/category/create')}}"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Thêm Category</a>
                @endcan
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Parent
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder  opacity-7">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <p class="text-xs text-center  mb-0" style="width:38%" >{{$category->id}}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0" >{{$category->name}}</p>
                            </td>
                            <td>
                                @if ($category->parent_id == 0)
                                    <p class="text-xs mb-0">Không có</p>
                                @elseif ($parent = \App\Models\admin\Category::find($category->parent_id))

                                    <p class="text-xs mb-0"> {{ $parent->name }}</p>
                                @endif
                            </td>
                            <td class="align-middle text-center ms-auto text-end">
                                @can('delete-category')
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" onclick="return confirmation(this)" href="{{url('admin/category/destroy/'. $category->id)}}" href="{{url('admin/category/destroy/'. $category->id)}}"><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</a>
                                @endcan
                                @can('edit-category')
                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{url('admin/category/edit/'. $category->id)}}"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{$categories->links('vendor.pagination.bootstrap-4')}}

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
