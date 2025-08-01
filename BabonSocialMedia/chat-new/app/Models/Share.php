<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Share extends Model
{
    use HasFactory;

    protected $table = 'shares';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'post_id',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
