<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Exception;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $comment = $request->all();
        $c = new Comment($comment);
        $user_id = Auth::user()->id;
        $filename = "";
        if ($request->file != null) {
            $file = $request->file('file');
            // dd($file);
            $ext = $file->getClientOriginalExtension(); //lay duoi file (.exe, .png, ...)
            $img_ext = ['jpg', 'jpeg', 'gif', 'png', 'svg'];
            if (in_array($ext, $img_ext)) { //kiem tra co dung dinh dang
                //kiem tra kich thuoc cua anh
                $size = $file->getSize();
                if ($size < 100 * 1024 * 1024) { //nho hon 5mb
                    //lay file name
                    $filename = $file->getClientOriginalName();
                    $filename = date("Y_m_d_His") . "_" . $user_id . "_" . $filename;
                    //chuyen file vao thu muc
                    // dd($filename);
                    $file->move('upload/post/', $filename);
                    // dd('ok');
                    $c->file = $filename;
                } else {
                    return back()->with('error', 'Size of Image must be smaller than 5 MB');
                }
            } else {
                return back()->with('error', 'Extension of Image is invalid !!');
            }
        } else { //k chon hinh thi lay hinh default
            // $filename = 'pDefault.png';
        }
        $c->content = preg_replace('/\n/', '<br>', $c->content);
        $c->content = preg_replace('/ /', '&nbsp;', $c->content);
        $c->user_id = $user_id;
        $c->save();
        return response()->json(array("cmtCount"=>Comment::where("post_id","=",$c->post_id)->count(),"comment_info"=>array("user"=>Auth::user(),"comment"=>$c)));
    }

    public function delete($id)
    {
        $cmt = Comment::find($id);
        try {
            $cmt->delete();
            return response()->json("Success");
        } catch (Exception $exc) {
            return response()->json("Failed");
        }
    }

    public function editCmt(Request $request) {
        $com = Comment::find($request->cmt_id);
        $user_id = Auth::user()->id;

        if ($request->file == "remain"){
            $filename = $com->file;
        } else {
            if ($request->file != null) {
                $file = $request->file('file');
                // dd($file);
                    $ext = $file->getClientOriginalExtension(); //lay duoi file (.exe, .png, ...)
                    $img_ext = ['jpg', 'jpeg', 'gif', 'png', 'svg'];
                if (in_array($ext, $img_ext)) { //kiem tra co dung dinh dang
                    // kiem tra kich thuoc cua anh
                    $size = $file->getSize();
                    if ($size < 5 * 1024 * 1024) { //nho hon 5mb
                        //lay file name
                        $filename = $file->getClientOriginalName();
                        $filename = date("Y_m_d_His") . "_" . $user_id . "_" . $filename;
                        //chuyen file vao thu muc
                        // dd($filename);
                        $file->move('upload/post/', $filename);
                        // dd('ok');
                        $com->file = $filename;
                    } else {
                        return back()->with('error', 'Size of Image must be smaller than 5 MB');
                    }
                } else {
                    return back()->with('error', 'Extension of Image is invalid !!');
                }
            } else { //k chon hinh thi lay hinh default
                $filename = "";
            }
        }
        $com->file = $filename;
        $com->content = preg_replace('/\n/', '<br>', $request->content);
        $com->content = preg_replace('/ /', '&nbsp;', $com->content);
        $com->save();
        return response()->json($com);
    }

    public function getCmt($id){
        return Comment::find($id);
    }
}
