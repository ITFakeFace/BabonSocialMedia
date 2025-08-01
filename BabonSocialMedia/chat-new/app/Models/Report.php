<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'post_id',
        'title',
        'content',
        //check status report done or not  
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function posts()
    {
        return $this->belongsTo(Post::class,'post_id', 'id');
    }
}
