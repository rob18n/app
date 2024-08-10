<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageKeyValue extends Model
{
    use HasFactory;

    protected $fillable = ['language_id', 'language_key_id', 'value'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
