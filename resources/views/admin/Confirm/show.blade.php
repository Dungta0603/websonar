@extends('admin.layout')

@section('title')
    Thêm Post
@endsection
@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                               href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a
                href="{{url('admin.confirm.index')}}" class="opacity-5 text-white>"></a>Confirm
        </li>
    </ol>
@endsection

@section('content')
    <div class="card mb-4 container">
        <div class="card-header pb-0">
            <h2>{{$post->title}}</h2>
        </div>
        <div class="card-body content-show px-3 pt-2 pb-2">
            {!! $post->content !!}
        </div>

        <a href="{{url('admin/confirm/index')}}" class="mt-3 btn">Quay lại</a>
    </div>
@endsection
