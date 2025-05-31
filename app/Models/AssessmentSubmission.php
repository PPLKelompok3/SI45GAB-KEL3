<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id',
        'user_id',
        'submission_text',
        'submission_file',
        'started_at',
        'submitted_at',
        'review_note',
        'reviewed_at',
    ];

    protected $dates = [
        'started_at',
        'submitted_at',
        'reviewed_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}