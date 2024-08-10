<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description'];

    protected $hidden = ['created_at', 'updated_at'];

    public function keys()
    {
        return $this->hasMany(LanguageKey::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'project_languages', 'project_id', 'language_id');
    }
}
