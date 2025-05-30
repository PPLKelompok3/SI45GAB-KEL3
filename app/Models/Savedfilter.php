<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SavedFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'label',
        'skill',
        'location',
        'min_score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(JobPost::class);
    }
}