<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Exception;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Emotion;
use App\Models\Comment;

class ReportController extends Controller
{
    public function createReport(Request $request){
        $rp = new Report();
        $rp->post_id = (int) $request->post_id;
        $rp->user_id = (int) $request->user_id;
        $rp->title = $request->title;
        $rp->content = $request->content;
        try{
            $rp->save();
        } catch(Exception $exc){
            return response()->json($exc);
        }
        return response()->json($request);
    }

    public function reportDetail($id){
        $report = Report::find($id);
        $post = Post::find($report->posts->id);
        if($report->status == '0'){
            $report->update(['status'=>'1']);
        }
        return view('admin/dashboard/admin/reportdetail', compact('report','post'));
    }

    public function deletePost($id){
        $post = Post::find($id);
        if($post){
            Emotion::where('post_id','=',$id)->delete();
            Comment::where('post_id','=',$id)->delete();
            Report::where('post_id','=',$id)->delete();
            $post->delete();
            return redirect('admin/dashboard/admin/listreport')->with('status', "Post has been deleted");
        } else {
            return redirect('admin/dashboard/admin/listreport')->with('status', "Post not found");
        }
    }

    public function isBan2($id)
    {
        $user = User::where('id',$id)->first();
        if ($user->status == '0') {
            $user->update(['status' => '1']);
        }
        return redirect('admin/dashboard/admin/listreport')->with('status', 'Banned ' . $user->username);
    }

    public function isDone($id){
        $report = Report::where('id', $id)->first();
        if($report->status == '0'){
            $report->update(['status'=>'1']);
        } else{
            $report->update(['status'=>'0']);
        }
        return redirect('admin/dashboard/admin/listreport')->with('status','Updated status report have id: '.$report->id);
    }
}
