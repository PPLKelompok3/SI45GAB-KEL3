<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPostAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
    'job_post_id',
    'type',
    'instruction',
    'attachment',
    'due_in_days',
    'essay_questions',
];

}