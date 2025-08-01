<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'content',
        'user_id',
        'file',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function comments()
    {
        return $this->hasMany(Emotion::class, 'post_id', 'id');
    }
    public function emotions()
    {
        return $this->hasMany(Emotion::class, 'post_id', 'id');
    }
    public function reports(){
        return $this->hasMany(Report::class, 'post_id','id');
    }
}
