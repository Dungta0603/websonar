<?php

namespace App\Http\Controllers\Admin;

use App\Events\postEvent;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Group;
use Illuminate\Support\Facades\Storage;

class postController extends Controller
{



    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), ['index' => 'view']);
    }

    public function index()
    {
            $posts = Post::where('status', 1)->paginate(6);
            Session::put('posts_url', request()->fullUrl());
            return view('admin.post.index', compact('posts'));
    }


    public function create()
    {
        if (auth()->user()->can('create-post')) {
        $categories = Category::all();
        $groups = Group::all();
        return view ('admin.post.create', compact('categories', 'groups'));
        } else {
            return abort(403);
        }
    }


    public function store(Request $request)
      {
        if ($request->isMethod('POST')) {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required',
                'avatar' => 'required',
                'short_description' => 'required',
                'is_landing' => 'required',
                'tags' => 'required',
                'slug' => 'required',
                'group_id' => 'required',
                'avatar' => 'required',

            ];
            $messages = [
                'required' => 'Không được để trống trường này',
            ];
            $request->validate($rules, $messages);
        }
        try {
            $input = $request->all();
            unset($input['_token']);
            unset($input['category_id']);
            unset($input['avatar']);
            $file = $request->file('avatar');
            $file->storeAs('image' , time().'.'.$file->getClientOriginalExtension(),'public');
            $image = time().'.'.$file->getClientOriginalExtension();
            $post = Post::create($input);
            $post->update([
                'avatar' => $image,
            ]);
            $post->categories()->attach($request->input('category_id'));
            $username = User::find($request->input('username'));
            event(new postEvent( $username ));
            if (Session::get('post_url')) {
                return redirect(session('post_url'))->with('success', 'Đã thêm post thành công');
            } else {
                return redirect('admin/post/index')->with('success', 'Đã thêm post thành công');
            }
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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

        if (auth()->user()->can('edit-post')) {
            $post = Post::find($id);
            $groups = Group::all();
            $categories = Category::all();
            $selectedID = $post->categories->pluck('id')->toArray();
            return view('admin.post.edit', compact('post', 'categories', 'selectedID', 'groups'));
        } else {
            return abort(403);
        }
    }


    public function update(Request $request, $id)
    {

        if ($request->isMethod('POST')) {
            $rules = [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required',
                'avatar' => 'required',
                'author' => 'required',
                'short_description' => 'required',
                'is_landing' => 'required',
                'group_id' => 'required',
                'slug' => 'slug'
            ];
            $messages = [
                'required' => 'Không được để trống trường này',
            ];
            $request->validate($rules, $messages);
        }
        try {
            $post = Post::find($id);
            $input = $request->all();
            unset($input['_token']);
            unset($input['category_id']);
            unset($input['avatar']);
            $post->update($input);
            $post->save();
            if($request->hasFile('avatar')) {
                $destination = 'storage/image/' . $post->avatar;
                if (File::exists($destination)) {
                    Storage::delete($post->avatar);
                }
                $file = $request->file('avatar');
                $file->storeAs('public/image', time() . '.' . $file->getClientOriginalExtension());
                $image = time() . '.' . $file->getClientOriginalExtension();

                $post->update([
                    'avatar' => $image,
                ]);
                $post->categories()->sync($request->input('category_id'));
            }
            if (Session::get('post_url')) {
                return redirect(session('post_url'))->with('success', 'Đã sửa post thành công');
            } else {
                return redirect('admin/post/index')->with('success', 'Đã sửa post thành công');
            }
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
            if (auth()->user()->can('delete-post')) {
                try {
                    $post = Post::find($id);
                    $this->authorize('delete', $post);
                    $post->delete();
                    if (Session::get('post_url')) {
                        return redirect(session('post_url'))->with('success', 'Đã xóa post thành công');
                    } else {
                        return redirect('admin/post/index')->with('success', 'Đã xóa post thành công');
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
            } else {
                return abort(403);
            }
    }


    public function restore() {
        $posts = Post::onlyTrashed()->paginate(6);
        return view('admin/post/restore', compact('posts'));
    }

    public function startRestore($id): \Illuminate\Http\RedirectResponse
    {
        Post::onlyTrashed()->find($id)->restore();
        return back()->with('success', 'Đã restore thành công');
    }

    public function delete($id){
        $post = Post::onlyTrashed()->find($id);
        $post->categories()->detach();
        $post->forceDelete();
        $this->authorize('delete', $post);
        return back()->with('success', 'Đã xóa product thành công');
    }
}
