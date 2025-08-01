<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'title',
        'priority',
        'categorize',
        'content',
        'image_bug',
        'date',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
