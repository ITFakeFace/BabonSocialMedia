<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function sendTicket(Request $request){
        $title = $request->input('title');
        $categorize_value = $request->input('categorize');
        $priority = $request->input('priority');
        $userID = $request->input('user_id');

        if($request->hasFile('image_bug')){
            $file = $request->file('image_bug');

            $ext = $file->getClientOriginalExtension(); 
            $accept_ext = ['jpg','jpeg', 'gif', 'png'];
            if(in_array($ext, $accept_ext))
            {
              $size = $file->getSize();
              if($size < 2*1024*1024*1024){

              $fileName = $file->getClientOriginalName();
              //doi ten hinh
              $fileName = date('d-m-Y') . '-' .$fileName;
              //dd($fileName);
              //move vao folder images
              $file->move("images/error/", $fileName);
              //dd("ok");
              } else{
                return back()->with('error','Hinh phai nho hon 2GB');
              }
            }else{
              return back()->with('error','Hinh chua dung dinh dang');
            }
        } else {
            $fileName = "";
        }
        $description = $request->input('content');
        $ticket = new Ticket;
        $ticket->user_id = $userID;
        $ticket->title = $title;
        $ticket->priority = $priority;
        $ticket->categorize = $categorize_value;
        $ticket->image_bug = $fileName;
        $ticket->content = $description;
        $ticket->save();
        return redirect('user/ticketsupport/'.$userID)->with('status','Ticket has been sent');
    }

    public function ticketDetail($id){
      $ticket = Ticket::find($id);
      return view('admin/dashboard/admin/ticketdetail', compact('ticket'));
  }

  public function answerTicket(Request $request){
      $answer = $request->input('answer');
      $id = $request->input('id');
      $ticket = Ticket::find($id);
      $ticket->answer = $request->answer;
      $username = $ticket->users->username;
      $ticket->save();
      $mail = new MailController;
      if($ticket->status == '0'){
        $ticket->update(['status'=>'1']);
      }  
      $subject = "$username ,Mail support from Babon team";
      $mail->sendMailSupport($subject,$ticket,$answer);
      return redirect('admin/dashboard/admin/ticketdetail/'.$id)->with('status','Problem was solved');  
  }
}
