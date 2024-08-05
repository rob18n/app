<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['key', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'language_language_key');
    }
}
