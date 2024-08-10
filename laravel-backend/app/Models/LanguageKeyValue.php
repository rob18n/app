<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageKeyValue extends Model
{
    use HasFactory;

    protected $fillable = ['language_id', 'language_key_id', 'value'];
}
