<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendShip extends Model
{
    use HasFactory;

    protected $table = 'friend_ships';

    protected $primaryKey = 'id';

    protected $fillable = [
        'userID_request',
        'userID_receive',
        'status'
    ];

    public function requestUser()
    {
        return $this->belongsTo(User::class, 'userID_request');
    }

    public function receiveUser()
    {
        return $this->belongsTo(User::class, 'userID_receive');
    }
}
