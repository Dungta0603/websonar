<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class groupController extends Controller
{

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $groups = Group::paginate(6);
        Session::put('group_url', request()->fullUrl());
        return view('admin.group.index', compact('groups'));
    }


    public function create()
    {
        return view('admin.group.create');
    }


    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required|max:255',
                'slug' => 'required',
            ];
            $messages = [
                'required' => 'Không được để trống trường này',
                'max' => 'Đã vượt qua số từ cho phép',
            ];
            $request->validate($rules, $messages);
        }
        try {
            $input = $request->all();
            unset($input['_token']);
            Group::create($input);
            if (Session::get('group_url')) {
                return redirect(session('group_url'))->with('success', 'Đã thêm group thành công');
            } else {
                return redirect('admin/group/index')->with('success', 'Đã thêm group thành công');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        if (Group::find($id)) {
            $group = Group::find($id);
            $groups = Group::all();
            return view('admin.group.edit', compact('groups', 'group'));
        } else {
            return back()->with('error', 'Không tìm thấy tài khoản');
        }

    }


    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required|max:255',
                'slug' => 'required',
            ];
            $messages = [
                'required' => 'Không được để trống trường này',
                'max' => 'Đã vượt qua số từ cho phép',
            ];
            $request->validate($rules, $messages);
        }
        try {
            $input = $request->all();
            unset($input['_token']);
            if (Group::find($id)) {
                $group  = Group::find($id);
                $group->update($input);
                if (Session::get('group_url')) {
                    return redirect(session('group_url'))->with('success', 'Đã sửa group thành công');
                } else {
                    return redirect('admin/group/index')->with('success', 'Đã sửa group thành công');
                }

            }else {
                return redirect()->back()->with('error', 'Không tìm thấy tài khoản');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi');
        }
    }


    public function destroy($id)
    {
        if (Group::find($id)) {
            Group::find($id)->delete();
            if (Session::get('category_url')) {
                return redirect(session('group_url'))->with('success', 'Đã xóa category thành công');
            } else {
                return redirect('admin/group/index')->with('success', 'Đã xóa category thành công');
            }
        } else {
            return back()->with('error', 'Không tìm thấy tài khoản');
        }

    }
}
