<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $primaryKey = 'id';

    protected $fillable = [
        'userID_send',
        'userID_receive',
        'content',
        'ApprovedDate',
    ];
}
