<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['user_id', 'company_name', 'industry', 'company_description', 'website', 'logo_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
    public function jobs()
    {
        return $this->hasMany(JobPost::class);
    }
        public function recruiter()
    {
        return $this->hasOne(User::class);
    }
    public function reviews()
{
    return $this->hasMany(CompanyReview::class);
}


}