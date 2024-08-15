<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LanguageKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['key', 'project_id', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function values()
    {
        return $this->hasMany(LanguageKeyValue::class);
    }
}
