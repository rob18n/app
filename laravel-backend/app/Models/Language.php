<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['shortkey'];

    protected $hidden = ['created_at', 'updated_at'];

    public function languageKeys()
    {
        return $this->belongsToMany(LanguageKey::class, 'language_language_key');
    }
}
