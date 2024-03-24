@extends('admin.layout')

@section('title')
    Trang user
@endsection
@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">User</li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Trang chủ</h6>
@endsection
@section('content')
    <div class="card mb-4">
    <div class="card-header pb-0">
      <h6>User table</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Permission</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cấp quyền</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr>
                <td>
                    <p class="text-xs text-center  mb-0" style="width:38%" >{{$user->id}}</p>
                  </td>
              <td>
                <div class="d-flex px-2 py-1">
                  <div>
                    <img src="{{asset('img/team-2.jpg')}}" class="avatar avatar-sm me-3" alt="user1">
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                    <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                  </div>
                </div>
              </td>
              <td class="align-middle text-sm">
                  @foreach($user->roles as $role)
                <span class="badge badge-sm bg-gradient-success">{{$role->name}}
                </span>
                  @endforeach
              </td>
                <td class="align-middle text-sm">
                    @if (count($user->permissions) > 0)
                        @foreach($user->permissions as $permission)
                            <span class="badge badge-sm bg-gradient-success">{{$permission->name}}
                            </span>
                        @endforeach
                    @else
                        @foreach($user->roles as $role)
                            @foreach($role->permissions as $permission)
                            <span class="badge badge-sm bg-gradient-success">{{$permission->name}}
                            </span>
                            @endforeach
                        @endforeach
                    @endif
                </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs"><a href="{{url('admin/user/role/' . $user->id)}}">Phân role</a></span>
                  <br>
                  <span class="text-secondary text-xs"><a href="{{url('admin/user/permission/' . $user->id)}}">Phân permision</a></span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  {{$users->links('vendor.pagination.bootstrap-4')}}
@endsection
