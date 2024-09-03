<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'student_number',
        'name',
        'place_of_birth',
        'date_of_birth',
        'edit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassList::class, 'classlist_student', 'student_id', 'classlist_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($student) {
            // Detach classes
            $student->classes()->detach();

            // Delete the associated user
            if ($student->user) {
                $student->user->forceDelete();
            }
        });
    }

    // Fetch all students from the database
    public static function fetchStudents()
    {
        return self::all();
    }

    // Find a student by student_number
    public static function findStudent($student_number)
    {
        return self::where('student_number', $student_number)->first();
    }

    public function requests()
    {
        return $this->hasMany(Requests::class, 'student_id');
    }
}
