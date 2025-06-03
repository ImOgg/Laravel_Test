<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'title',
        'author_id',
    ];
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
