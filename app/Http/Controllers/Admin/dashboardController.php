<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Service\admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class dashboardController extends Controller
{

    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        Session::put('user-url', request()->fullUrl());
        $users = $this->userService->paginate(6);
        return view('admin.user.index',compact('users'));
    }

    public function role($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.user.role', compact('roles', 'user'));
    }

    public function doRole(Request $request, $id){
        $user = User::find($id);
        $user->roles()->sync($request->role_id);
        $users = User::paginate(6);
        return view('admin.user.index', compact('users'))->with('success', 'Đã sửa role');
    }


    public function permission($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($id);
        $permissions = Permission::all();
        return view('admin.user.permission', compact('permissions', 'user'));
    }

    public function doPermission($id, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($id);
        $permissionIDs = $request->permission_id;

        if (empty($permissionIDs)) {
            $user->permissions()->detach();
        } elseif(count($permissionIDs) > count($user->permissions)) {
            foreach ($permissionIDs as $permission){
                $user->permissions()->attach($permission);
            }
        } else {
            foreach ($permissionIDs as $permission){
                $user->permissions()->sync($permission);
            }
        }

        $users = User::paginate(6);
        return view('admin.user.index', compact('users'))->with('success', 'Đã sửa permission');
    }
}
