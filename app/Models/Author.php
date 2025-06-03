<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
    ];
    public function books()
    {
        return $this->hasMany(Books::class);
    }
}
