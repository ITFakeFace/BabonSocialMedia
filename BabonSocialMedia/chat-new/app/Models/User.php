<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\FriendShip;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Emotion;
use App\Models\Share;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'password',
        'email',
        'phone',
        'level',
        'rememberToken',

        'avatar',
        'coverPhoto',
        'personalImage',
        'dob',
        'gender',
        'status',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function FriendShips_request()
    {
        return $this->hasMany(FriendShip::class, 'userID_request','id');
    }
    public function FriendShips_receive()
    {
        return $this->hasMany(FriendShip::class, 'userID_receive','id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentUser_id', 'id');
    }
    public function emotions()
    {
        return $this->hasMany(Emotion::class, 'emotionUser_id', 'id');
    }
    public function shares()
    {
        return $this->hasMany(Share::class, 'emotionUser_id', 'id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class,'user_id','id');
    }
    public function reports(){
        return $this->hasMany(Report::class,'user_id','id');
    }

    public function FriendRequest()
    {
        return $this->belongsToMany(User::class, 'friend_ships', 'userID_receive', 'userID_request')
                ->wherePivot('status', 1);
    }
     //Return userID_receive with status = 1 to the Logged in User 
    public function FriendReceive(){
        
        return $this->belongsToMany(User::class, 'friend_ships', 'userID_request', 'userID_receive')
        ->wherePivot('status', 1);
    }

    // Return userID_request with status = 0 to the Logged in User
    public function NotFriendReceive()
    {
        return $this->belongsToMany(User::class, 'friend_ships', 'userID_request', 'userID_receive')
            ->wherePivot('status', 0);
    }
    //Return userID_receive with status = 0 to the Logged in User
    public function NotFriendRequest()
    {
        return $this->belongsToMany(User::class, 'friend_ships', 'userID_receive', 'userID_request')
            ->wherePivot('status', 0);
    }
}

