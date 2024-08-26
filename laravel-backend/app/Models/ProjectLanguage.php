<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectLanguage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_languages';

    protected $fillable = ['project_id', 'language_id'];

    public function keys()
    {
        return $this->hasMany(LanguageKey::class, 'id', 'language_id');
    }
}
