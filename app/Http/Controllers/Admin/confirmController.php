<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Http\Request;

class confirmController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $posts = Post::where('status', 0)->paginate(6);
        return view('admin.confirm.index', compact('posts'));
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->first();
        return view('admin.confirm.show', compact('post'));
    }

    public function status(Request $request): \Illuminate\Http\RedirectResponse
    {

        if(!(empty($request->confirm_id))){
            try{
                $posts = Post::whereIn('id',$request->confirm_id)->get();
                foreach($posts as $post){
                    $post = Post::where('id',$post->id)
                        ->update(
                            [
                                'status' => 1,
                            ]
                        );
                }
                return redirect()->back()->with('success', 'Đã xác nhận');
            }catch(Exception $e){
                return redirect()->back()->with('error','Đã xảy ra lỗi');
            }
        }else{
            return redirect()->back()->with('error','Bạn cần xác nhận post');
        }
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $post = Post::find($id);
        $post->categories()->detach();
        $post->forceDelete();
        $this->authorize('delete', $post);
        return back()->with('success', 'Đã xóa product thành công');
    }
}
