<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description'];

    protected $with = ['languages'];

    public function languageKeys()
    {
        return $this->hasMany(LanguageKey::class);
    }

    public function languages()
    {
        return $this->hasMany(ProjectLanguage::class);
    }
}
