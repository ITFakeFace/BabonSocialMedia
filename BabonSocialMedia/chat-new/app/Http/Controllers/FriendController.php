<?php
namespace App\Http\Controllers;

use App\Models\FriendShip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\FriendNotifications;
use Pusher\Pusher;
class FriendController extends Controller
{
    public function makeFriend(Request $request)
    {
        $friendId = $request->friend_id;
        $user = User::find(Auth::id());
        $friend = User::find($friendId);

        $friendship = new FriendShip();
        $friendship->userID_request = $user->id;
        $friendship->userID_receive = $friend->id;
        $friendship->status = false;
        $friendship->save();

        //send notifications to receiver
        $friend->notify(new FriendNotifications($user));

        $makeFriendNotify = $friend->notifications;

        // Gửi thông báo tới người nhận
        // Generate the unique channel name for the recipient
        $channelName = 'notify-' . $friend->id;
        // Sử dụng Pusher để gửi thông báo realtime
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => 'ap1',
            'encrypted' => true,
        ]);

        $pusher->trigger($channelName, 'friend-request', [
            'user_id' => $user->id,
            'username' => $user->username,
            'message' => 'You have a friend request from ' . $user->username,
        ]);


        // Redirect or return a response as needed
        // return Redirect::route('home')->with([
        //     'status' => 'Make friends successfully',
        //     'makeFriendNotify' => $makeFriendNotify,
        // ]);
        return response()->json([
            'message' => 'Make friends successfully',
            // 'makeFriendNotify' => $makeFriendNotify,
        ]);
    }
    public function removeFriend(Request $request)
    {
        $friendId = $request->input('friend_id');
        $currentUser = User::find(Auth::id());

        $findfriendrequest = FriendShip::where([
            'userID_request' => $currentUser->id,
            'userID_receive' => $friendId,
            'status' => 1
        ])->delete();

        $findfriendreceive = FriendShip::where([
            'userID_request' => $friendId,
            'userID_receive' => $currentUser->id,
            'status' => 1
        ])->delete();


        // Redirect or return a response as needed
        return Redirect::route('view.profile.userprofile')->with('status','Remove successfully');
    }

    public function acceptFriendRequest(Request $request)
    {
        $currentUser = User::find(Auth::id());
        $friendId = $request->input('friend_id');

        $findfriendrequest = FriendShip::where([
            'userID_request' => $friendId,
            'userID_receive' => $currentUser->id,
            'status' => 0
        ])

            ->update(['status' => 1]);
        $currentUser->unreadNotifications()->update(['read_at' => now()]);

        $channelName = 'receive-' . $friendId;
        // Sử dụng Pusher để gửi thông báo realtime
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => 'ap1',
            'encrypted' => true,
        ]);

        $pusher->trigger($channelName, 'friend-accept', [
            'user_id' => $currentUser->id,
            'username' => $currentUser->username,
            'message' => 'You and ' . $currentUser->username .' are friends now, Lets chat to know more',
        ]);

        return Redirect::route('view.profile.userprofile')->with('status', 'Lets get to know more together');
    }

    public function cancelFriendRequest(Request $request)
    {
        $currentUser = User::find(Auth::id());
        $friendId = $request->friend_id;

        $findfriendrequest = FriendShip::where([
            'userID_request' => $currentUser->id,
            'userID_receive' => $friendId,
            'status' => 0
        ])->delete();


        return Redirect::route('view.profile.userprofile')->with('status', 'Friend request accepted successfully.');
    }

    public function rejectFriendRequest(Request $request){
        $currentUser = User::find(Auth::id());
        $friendId = $request->input('friend_id');
        $findfriendrequest = FriendShip::where([
            'userID_request' => $friendId,
            'userID_receive' => $currentUser->id,
            'status' => 0
        ])->delete();
        $currentUser->unreadNotifications()->update(['read_at' => now()]);
        return Redirect::route('view.profile.userprofile')->with('status', 'Sorry to get to know about this');
    }

    public function markAsRead($id){
        $user = User::find($id);
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }
}
