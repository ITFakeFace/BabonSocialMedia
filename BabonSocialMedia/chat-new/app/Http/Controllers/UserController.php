<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\Comment;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        $totalUser =  User::count();
        $totalPost = Post::count();
        $totalTicket= Ticket::count();
        $totalReport = Report::count();
        $countTicket = Ticket::where('status','0')->count();
        return view('admin.dashboard.index', compact('users','totalUser','totalPost','totalTicket','countTicket','totalReport'));

    }


    public function listUser(){
        $users = User::where('level','0')->get();
        $totalTickets = [];
        $totalReports = [];
        foreach ($users as $user) {
            $totalTickets[$user->id] = Ticket::where('user_id', $user->id)->count();
            $tickets[$user->id] = Ticket::where('user_id', $user->id)->where('status','0')->count();
        }
        foreach ($users as $user) {
            $totalReports[$user->id] = Report::where('user_id', $user->id)->count();
            $reports[$user->id] = Report::where('user_id', $user->id)->where('status','0')->count();
        }

        return view('admin.dashboard.user.listuser', compact('users','totalTickets','totalReports','tickets','reports'));
    }

    public function listUserBan(){
        $users = User::where('level','0')->where('status','1')->get();
        $totalTickets = [];
        $totalReports = [];
        foreach ($users as $user) {
            $totalTickets[$user->id] = Ticket::where('user_id', $user->id)->count();
        }
        foreach ($users as $user) {
            $totalReports[$user->id] = Report::where('user_id', $user->id)->count();
        }

        return view('admin.dashboard.user.listuserban', compact('users','totalTickets','totalReports'));
    }

    public function listTicket(){
        $tickets = Ticket::all();
        return view('admin.dashboard.admin.listticket', compact('tickets'));
    }

    public function listReport(){
        $reports = Report::all();
        return view('admin.dashboard.admin.listreport', compact('reports'));
    }

    public function listAdmin(){
        $users = User::where('level','1')->get();
        return view('admin.dashboard.admin.listadmin', compact('users'));
    }

    public function isBan($id){
        $users = User::where('id', $id)->first();
        if($users->status == '0'){
            $users->update(['status'=>'1']);
        } else{
            $users->update(['status'=>'0']);
        }
        return redirect('admin/dashboard/user/listuser')->with('status','Updated status account have id: '.$users->id);
    }

    public function isDone($id){
        $ticket = Ticket::where('id', $id)->first();
        if($ticket->status == '0'){
            $ticket->update(['status'=>'1']);
        } else{
            $ticket->update(['status'=>'0']);
        }
        return redirect('admin/dashboard/admin/listticket')->with('status','Updated status ticket have id: '.$ticket->id);
    }


    public function viewProfile(){
        $user = User::find(Auth::user()->id);
        return view('user.userprofile', compact('user'));
    }

    public function viewProfileAdmin(){
        $user = User::find(Auth::user()->id);
        $post = Post::where('user_id', $user->id)->orderBy('created_at','desc')->get();
        return view('admin.adminprofile', compact('user','post'));
    }



    public function editProfile($id){
        $user = User::find($id);
        $totalPosts = Post::where('user_id',$user->id)->count();
        $totalTickets = Ticket::where('user_id',$user->id)->count();
        $totalReports = Report::where('user_id',$user->id)->count();
        return view('user.editprofile', compact('user','totalPosts','totalTickets','totalReports'));
    }

    public function updateProfile(Request $request){
            $user = User::find(Auth::user()->id);
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->save();
            return redirect('user/editprofile/'.$user->id)->with('status','Update information user succesfully');
        }

        public function updatePassword(Request $request){
            $user = User::find(Auth::user()->id);
            $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required|same:new_password'
            ]);

            if(!Hash::check($request->old_password, auth()->user()->password)){
                 return back()->with("error", "Old Password Doesn't match!");
             }


             User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
             ]);

            return redirect('user/editprofile/'.$user->id)->with("status2", "Password changed successfully!");
    }

    public function updateDescription(Request $request){
        $user = User::find(Auth::user()->id);
        $user->description = $request->description;
        $user->save();
        return redirect('user/editprofile/'.$user->id)->with('status3','Update description succesfully');
    }

    public function updateAvatar(Request $request){
        $user = User::find(Auth::user()->id);
                //kiem tra xem co chon hinh hay khong
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension(); //lay duoi cua file hinh
                    $accept_ext = ['jpg','jpeg', 'gif', 'png'];
                    if(in_array($ext, $accept_ext))//kiem tra co dung dinh dang
                    {
                      //kiem tra kich thuoc cua hinh
                      $size = $file->getSize();
                      if($size < 2*1024*1024*1024){
                        //nho hon 2MB
                         //lay ten file hinh
                      $fileName = $file->getClientOriginalName();
                      //doi ten hinh
                      $fileName = date('d-m-Y') . '-' .$fileName;
                      //dd($fileName);
                      //move vao folder images
                      $file->move("images/", $fileName);
                      //dd("ok");
                      } else{
                        return back()->with('errorAvatar','Image size < 2MB');
                      }
                    }else{
                      return back()->with('errorAvatar','Image not found');
                    }
                } else{
                    //khong chon hinh thu lay hinh cu
                    $fileName = $user->avatar;
                }
                $user->avatar = $fileName;
                $user->save();
                return redirect('user/editprofile/'.$user->id)->with('status','Update avatar successfully');
    }

    public function updateCover(Request $request){
        $user = User::find(Auth::user()->id);
                //kiem tra xem co chon hinh hay khong
                if($request->hasFile('coverimage')){
                    $file = $request->file('coverimage');
                    $ext = $file->getClientOriginalExtension(); //lay duoi cua file hinh
                    $accept_ext = ['jpg','jpeg', 'gif', 'png'];
                    if(in_array($ext, $accept_ext))//kiem tra co dung dinh dang
                    {
                      //kiem tra kich thuoc cua hinh
                      $size = $file->getSize();
                      if($size < 2*1024*1024*1024){
                        //nho hon 2MB
                         //lay ten file hinh
                      $fileName = $file->getClientOriginalName();
                      //doi ten hinh
                      $fileName = date('d-m-Y') . '-' .$fileName;
                      //dd($fileName);
                      //move vao folder images
                      $file->move("images/", $fileName);
                      //dd("ok");
                      } else{
                        return back()->with('errorAvatar','Image size < 2MB');
                      }
                    }else{
                      return back()->with('errorAvatar','Image not found');
                    }
                } else{
                    //khong chon hinh thu lay hinh cu
                    $fileName = $user->coverPhoto;
                }
                $user->coverPhoto = $fileName;
                $user->save();
                return redirect('user/editprofile/'.$user->id)->with('status','Update cover successfully');
    }

    public function viewUserProfile($id){
        $user = User::find($id);
        $posts = Post::where('user_id', $user->id)->get();
        $ticket = Ticket::where('user_id', $user->id)->get();
        $report = Report::where('user_id', $user->id)->get();
        $totalPosts = Post::where('user_id',$user->id)->count();
        $totalTickets = Ticket::where('user_id',$user->id)->count();
        $totalReports = Report::where('user_id',$user->id)->count();
        return view('admin.dashboard.user.viewprofileuser', compact('posts','user','ticket','report','totalPosts','totalTickets','totalReports'));
    }

    public function ticketSupport($id){
        $user = User::find($id);
        return view('user.ticketsupport', compact('user'));
    }

    public function viewInfo($id)
    {
        $user = User::find($id);
        $userLoggedin = Auth::user();
        // $post = Post::all(); // show all the Posts from many users
         $post = $user->posts; //show only Posts which belong to user log in already
        $comment = Comment::all();
        // return view('home'); //originals

        $FriendRequestor = $user->FriendRequest;
        $FriendReceveior = $user->FriendReceive;
        $NotFriendRequestor = $user->NotFriendRequest;
        $NotFriendReceveior = $user->NotFriendReceive;

        $Friended = collect();
        if ($FriendRequestor && $FriendReceveior) {
            $Friended = $FriendRequestor->merge($FriendReceveior);
        }

        $strangers = User::whereNotIn('id', optional($FriendRequestor)->pluck('id') ?? [])
            ->whereNotIn('id', optional($FriendReceveior)->pluck('id') ?? [])
            ->whereNotIn('id', optional($NotFriendRequestor)->pluck('id') ?? [])
            ->whereNotIn('id', optional($NotFriendReceveior)->pluck('id') ?? [])
            ->where('id', '!=', $user->id) //remove id of User who aready logged in
            ->limit(8)
        ->get();

        return view('user.userinfo',compact('user','post', 'Friended','NotFriendRequestor','NotFriendReceveior','strangers','userLoggedin'));
    }

    public function viewInfo2()
    {
        $user = User::find(Auth::id());
        // $post = Post::all(); // show all the Posts from many users
         $post = $user->posts; //show only Posts which belong to user log in already
        $comment = Comment::all();
        // return view('home'); //originals

          $FriendRequestor = $user->FriendRequest;
          $FriendReceveior = $user->FriendReceive;
          $NotFriendRequestor = $user->NotFriendRequest;
          $NotFriendReceveior = $user->NotFriendReceive;

           $Friended = $FriendRequestor->merge($FriendReceveior);

        $strangers = User::whereNotIn('id', $FriendRequestor->pluck('id'))
        ->whereNotIn('id', $FriendReceveior->pluck('id'))
        ->whereNotIn('id', $NotFriendRequestor->pluck('id'))
        ->whereNotIn('id', $NotFriendReceveior->pluck('id'))
        ->where('id', '!=', $user->id) //remove id of User who aready logged in
        ->limit(8)
        ->get();

        //check notifications
        $notifications = $user->unreadNotifications ;

        return view('user.userprofile',compact('user','post', 'Friended','NotFriendRequestor','NotFriendReceveior','strangers','notifications'));

    }
}
