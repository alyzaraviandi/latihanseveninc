<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Head extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'prof_number', 'nip', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
