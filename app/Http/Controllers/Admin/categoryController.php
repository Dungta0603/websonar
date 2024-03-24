<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class categoryController extends Controller
{

    protected function resourceAbilityMap()
    {
        return array_merge(parent::resourceAbilityMap(), ['index' => 'view']);
    }

    public function index()
    {
        $categories = Category::paginate(6);
        Session::put('category_url', request()->fullUrl());
        return view('admin.category.index', compact('categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', compact('categories'));
    }


    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required|max:255',
                'parent_id' => 'required',
                'category_id' => 'required',
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
            Category::create($input);
            if (Session::get('category_url')) {
                return redirect(session('category_url'))->with('success', 'Đã thêm category thành công');
            } else {
                return redirect('admin/category/index')->with('success', 'Đã thêm category thành công');
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


    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        $selectedID = $categories->pluck('parent_id')->toArray();
        return view('admin.category.edit', compact('categories', 'category', 'selectedID'));
    }


    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required|max:255',
                'parent_id' => 'required',
                'slug' => 'required',
            ];
            $messages = [
                'required' => 'Không được để trống trường này',
                'max' => 'Đã vượt qua số từ cho phép',
            ];
            $request->validate($rules, $messages);
        }
        try {
            $category = Category::find($id);
            $input = $request->all();
            unset($input['_token']);
            $category->update($input);
            if (Session::get('category_url')) {
                return redirect(session('category_url'))->with('success', 'Đã sửa category thành công');
            } else {
                return redirect('admin/category/index')->with('success', 'Đã sửa category thành công');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        if (Session::get('category_url')) {
            return redirect(session('category_url'))->with('success', 'Đã xóa category thành công');
        } else {
            return redirect('admin/category/index')->with('success', 'Đã xóa category thành công');
        }
    }
}
