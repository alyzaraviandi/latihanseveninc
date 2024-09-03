<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prof extends Model
{
    use HasFactory;

    protected $table = 'profs';

    protected $fillable = [
        'user_id',
        'prof_number',
        'nip',
        'name',
    ];

    public function classes()
    {
        return $this->hasMany(ClassList::class, 'prof_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
