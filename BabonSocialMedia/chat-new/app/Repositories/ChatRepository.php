<?php

namespace App\Repositories;

use App\Models\FriendShip;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class ChatRepository
{
    public function getUser(int $userId): array {
        $user = User::find($userId);
        return $user ? $user->toArray() : [];
    }

    public function getFriend(int $requestId): array
    {
        $friends = FriendShip::where(function ($query) use ($requestId) {
            $query->where('userID_request', $requestId)
                ->where('status', 1);
        })
            ->orWhere(function ($query) use ($requestId) {
                $query->where('userID_receive', $requestId)
                    ->where('status', 1);
            })
            ->with(['requestUser', 'receiveUser']) // Load the related users
            ->get();

        $friendData = [];

        foreach ($friends as $friend) {
            if ($friend->userID_request == $requestId ) {
                $friendData[] = [
                    'userID' => $friend->userID_receive,
                    'friendName' => $friend->receiveUser->username,
                    'friendAvatar' => $friend->receiveUser->avatar,
                ];
            } elseif ($friend->userID_receive == $requestId ) {
                $friendData[] = [
                    'userID' => $friend->userID_request,
                    'friendName' => $friend->requestUser->username,
                    'friendAvatar' => $friend->requestUser->avatar,
                ];
            }
        }

        return $friendData;
    }

    public function getUserMessages(int $senderId, int $receiverId)
    {
        $messages = Message::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->get();

        $users = User::whereIn('id', [$senderId, $receiverId])
            ->get()
            ->keyBy('id');

        $messages->each(function ($message) use ($users) {
            $message->sender_name = $users[$message->sender_id]->username;
            $message->receiver_name = $users[$message->receiver_id]->username;
            $message->sender_avatar = $users[$message->sender_id]->avatar;
            $message->receiver_avatar = $users[$message->receiver_id]->avatar;
        });

        return $messages;
    }

//    public function getFriends(int $user_id)
//    {
//        return friendTable::whereIn('user_id', [$senderId, $receiverId])
//            ->whereIn('receiver_id', [$senderId, $receiverId])
//            ->get();
//    }

    public function getRecentUsersWithMessage(int $senderId) : array {
        DB::statement("SET SESSION sql_mode=''");
//        $recentMessages = Message::where(function ($query) use ($senderId) {
//           $query->where('sender_id',$senderId)
//                 ->orWhere('receiver_id',$senderId);
//        })->groupBy('sender_id', 'receiver_id')
//            ->select('sender_id', 'receiver_id', 'message','created_at')
//            ->orderBy('created_at', 'desc')
//            ->limit(30)
//            ->get();
        $recentMessages = Message::whereIn('id', function ($query) use ($senderId) {
            $query->select(DB::raw('MAX(id)'))
                ->from('messages')
                ->where('receiver_id', $senderId)
                ->groupBy('sender_id');
        })
            ->orWhere(function ($query) use ($senderId) {
                $query->whereIn('id', function ($subquery) use ($senderId) {
                    $subquery->select(DB::raw('MAX(id)'))
                        ->from('messages')
                        ->where('sender_id', $senderId)
                        ->groupBy('receiver_id');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();


        return $this->getFilterRecentMessages($recentMessages, $senderId);
    }

    public function sendMessage(array $data) : Message
    {
        return Message::create($data);
    }

    public function getFilterRecentMessages(Collection $recentMessages, int $senderId) : array
    {
        $recentUsersWithMessage = [];
        $usedUserIds = [];
        foreach ($recentMessages as $message) {
            $userId = $message->sender_id == $senderId ? $message->receiver_id : $message->sender_id;
            if (!in_array($userId, $usedUserIds)) {
                $recentUsersWithMessage[] = [
                    'user_id' => $userId,
                    'message' => $message->message,
                    'created_at' => $message->created_at
                ];
                $usedUserIds[] = $userId;
            }
        }

        foreach ($recentUsersWithMessage as $key => $userMessage) {
            $recentUsersWithMessage[$key]['username'] = User::where('id', $userMessage['user_id'])->value('username') ?? '';
            $recentUsersWithMessage[$key]['avatar'] = User::where('id', $userMessage['user_id'])->value('avatar') ?? '';
        }
        return $recentUsersWithMessage;
    }
}
