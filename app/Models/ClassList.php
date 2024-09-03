<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassList extends Model
{
    use HasFactory;

    protected $table = 'classlists';

    protected $fillable = [
        'name',
        'class_id',
        'sum',
        'prof_id',
    ];

    /**
     * Get the professor that manages the class.
     */
    public function professor()
    {
        return $this->belongsTo(Prof::class, 'prof_id');
    }

    /**
     * Method to check if the class is full.
     */
    public function isFull()
    {
        return $this->students()->count() >= $this->sum;
    }

    /**
     * Many-to-Many Relationship with Students.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'classlist_student', 'classlist_id', 'student_id');
    }

    /**
     * Get the current number of students in the class.
     */
    public function currentStudentCount()
    {
        return $this->students()->count();
    }

    public function requests()
    {
        return $this->hasMany(Requests::class, 'class_id');
    }
}
