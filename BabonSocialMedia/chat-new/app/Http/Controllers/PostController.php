<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Emotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use Exception;
use App\Models\Report;

class PostController extends Controller
{
    public function index1(){
        $posts = Post::orderBy('id','desc')->get();
        $post_array = [];
        foreach($posts as $post){
            $user = User::find($post->user_id);
            $like = Emotion::where("post_id","=",$post->id)->where("type","=",1)->count();
            $dislike = Emotion::where("post_id", "=", $post->id)->where("type", "=", 2)->count();
            $emoteStatus = Emotion::where("post_id", "=", $post->id)->where("user_id","=",$user->id)->first();
            $comments = Comment::where("post_id","=",$post->id);
            if ($emoteStatus != NULL){
                $emoteType = $emoteStatus->type;
            } else {
                $emoteType = 0;
            }
            $extra = array("user"=>$user,"avatar"=>$user->avatar,"like"=>$like,"dislike"=>$dislike,"emoteStatus"=>$emoteType,"comments"=>$comments);
            $post_array_element = array("post" => $post, "extra" => $extra);
            array_push($post_array,$post_array_element);
        }
        return view('newsfeed', ["posts"=> $post_array]);
    }

    public function create(Request $request){
        $post = $request->all();
        $p = new Post($post);
        $user_id = Auth::user()->id;
        $filename = "";
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // dd($file);
            $ext = $file->getClientOriginalExtension(); //lay duoi file (.exe, .png, ...)
            $img_ext = ['jpg', 'jpeg', 'gif', 'png','svg'];
            if (in_array($ext, $img_ext)) { //kiem tra co dung dinh dang
                //kiem tra kich thuoc cua anh
                $size = $file->getSize();
                if ($size < 100 * 1024 * 1024) { //nho hon 5mb
                    //lay file name
                    $filename = $file->getClientOriginalName();
                    $filename = date("Y_m_d_His") ."_". $user_id ."_". $filename;
                    //chuyen file vao thu muc
                    // dd($filename);
                    $file->move('upload/post/', $filename);
                    // dd('ok');
                    $p->file = $filename;
                } else {
                    return back()->with('error', 'Size of Image must be smaller than 5 MB');
                }
            } else {
                return back()->with('error', 'Extension of Image is invalid !!');
            }
        } else { //k chon hinh thi lay hinh default
            // $filename = 'pDefault.png';
        }
        $p->content = preg_replace('/\n/','<br>',$p->content);
        $p->content = preg_replace('/ /', '&nbsp;', $p->content);
        $p->user_id = $user_id;
        $p->save();
        return response()->json(array("post"=>$p,"user"=>User::find($user_id)));
        // return response()->json("Test");
    }
    
    public function getPost(Request $request){
        $post = Post::find($request->post_id);
        $post_array = [];
        $user = User::find($post->user_id);
        $like = Emotion::where("post_id", "=", $post->id)->where("type", "=", 1)->count();
        $dislike = Emotion::where("post_id", "=", $post->id)->where("type", "=", 2)->count();
        $emoteStatus = Emotion::where("post_id", "=", $post->id)->where("user_id", "=", $user->id)->first();
        $comments = Comment::where("post_id", "=", $post->id)->orderBy("id","desc")->get();
        $comments_full = array();
        if ($emoteStatus != NULL) {
            $emoteType = $emoteStatus->type;
        } else {
            $emoteType = 0;
        }
        foreach($comments as $com){
            $comment_info = array("comment_info"=>$com,"username" => User::find($com->user_id)->username, "avatar" => User::find($com->user_id)->avatar);
            array_push($comments_full,$comment_info);
        }
        $extra = array("username" => $user->username, "avatar" => $user->avatar, "like" => $like, "dislike" => $dislike, "emoteStatus" => $emoteType, "comments" => $comments_full, "comment_count" => count($comments));
        $post_array_element = array("post" => $post, "extra" => $extra);
        array_push($post_array, $post_array_element);
        return response()->json($post_array);
    }

    public function delete($id){
        $post = Post::find($id);
        try{
            Emotion::where('post_id','=',$id)->delete();
            Comment::where('post_id','=',$id)->delete();
            $post->delete();
            return response()->json("Success");
        } catch(Exception $exc){
            return response()->json("Failed");
        }
    }

    public function edit(Request $request){
        $post = Post::find($request->post_id);
        $user_id = Auth::user()->id;
        if ($request->file != null) {
            $file = $request->file('file');
            // dd($file);
            $ext = $file->getClientOriginalExtension(); //lay duoi file (.exe, .png, ...)
            $img_ext = ['jpg', 'jpeg', 'gif', 'png', 'svg'];
            if (in_array($ext, $img_ext)) { //kiem tra co dung dinh dang
                //kiem tra kich thuoc cua anh
                $size = $file->getSize();
                if ($size < 5 * 1024 * 1024) { //nho hon 5mb
                    //lay file name
                    $filename = $file->getClientOriginalName();
                    $filename = date("Y_m_d_His") . "_" . $user_id . "_" . $filename;
                    //chuyen file vao thu muc
                    // dd($filename);
                    $file->move('upload/post/', $filename);
                    // dd('ok');
                    $post->file = $filename;
                } else {
                    return back()->with('error', 'Size of Image must be smaller than 5 MB');
                }
            } else {
                return back()->with('error', 'Extension of Image is invalid !!');
            }
        } else { //k chon hinh thi lay hinh default
            $filename = "";
        }
        $post->file = $filename;
        $post->content = preg_replace('/\n/', '<br>', $request->content);
        $post->content = preg_replace('/ /', '&nbsp;', $post->content);
        $post->save();
        return response()->json($post);
    }

    public function deletePostAdmin($id){
        $post = Post::find($id);
        if($post){
            Emotion::where('post_id','=',$id)->delete();
            Comment::where('post_id','=',$id)->delete();
            Report::where('post_id','=',$id)->delete();
            $post->delete();
            return redirect('admin/adminprofile');
        }
    }

    public function createPostAdmin(Request $request){
        $post = $request->all();
        $p = new Post($post);
        $user_id = Auth::user()->id;
        $filename = "";
        if ($request->hasFile('post-file')) {
            $file = $request->file('post-file');
            // dd($file);
            $ext = $file->getClientOriginalExtension(); //lay duoi file (.exe, .png, ...)
            $img_ext = ['jpg', 'jpeg', 'gif', 'png','svg'];
            if (in_array($ext, $img_ext)) { //kiem tra co dung dinh dang
                //kiem tra kich thuoc cua anh
                $size = $file->getSize();
                if ($size < 100 * 1024 * 1024) { //nho hon 5mb
                    //lay file name
                    $filename = $file->getClientOriginalName();
                    $filename = date("Y_m_d_His") ."_". $user_id ."_". $filename;
                    //chuyen file vao thu muc
                    // dd($filename);
                    $file->move('upload/post/', $filename);
                    // dd('ok');
                    $p->file = $filename;
                } else {
                    return back()->with('error', 'Size of Image must be smaller than 5 MB');
                }
            } else {
                return back()->with('error', 'Extension of Image is invalid !!');
            }
        } else { //k chon hinh thi lay hinh default
            // $filename = 'pDefault.png';
        }
        $p->content = preg_replace('/\n/','<br>',$p->content);
        $p->content = preg_replace('/ /', '&nbsp;', $p->content);
        $p->user_id = $user_id;
        $p->save();
        return redirect('admin/adminprofile');

    }
}
