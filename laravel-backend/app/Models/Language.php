<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['shortkey'];

    protected $hidden = ['created_at', 'updated_at'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_languages', 'language_id', 'project_id');
    }
}
