<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function skills()
{
    return $this->belongsToMany(Skill::class, 'article_skill');
}

public function author()
{
    return $this->belongsTo(User::class, 'user_id');
}

}