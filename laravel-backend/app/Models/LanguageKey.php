<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use ZipArchive;

class LanguageKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['key', 'project_id', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['filled_values_counter', 'empty_value_counter'];

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

    // attributes

    public function getFilledValuesCounterAttribute()
    {
        $totalValues = $this->values()->count();
        $filledValues = $this->values()->where('value', '!=', '')->count();

        return "{$filledValues}/{$totalValues}";
    }

    public function getEmptyValueCounterAttribute()
    {
        $totalValues = $this->values()->count();
        $filledValues = $this->values()->where('value', '!=', '')->count();
        return $totalValues - $filledValues;
    }

    // methods

    static public function zip($fileData, $format)
    {
        $publicPath = public_path('rob18n-lang');  // Verzeichnis im public Ordner
        $zipFilePath = public_path('rob18n-lang.zip');  // Pfad zur ZIP-Datei im public Ordner

        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0755, true);
        }

        $fileData->each(function ($item) use ($publicPath, $format) {
            $shortKey = $item->get('shortKey');
            $entries = $item->get('entries');
            $jsonContent = $entries->toJson(JSON_PRETTY_PRINT);
            $filePath = "{$publicPath}/{$shortKey}.{$format}";
            File::put($filePath, $jsonContent);
        });

        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = File::files($publicPath);
            foreach ($files as $file) {
                $zip->addFile($file->getRealPath(), "rob18n-lang/{$file->getFilename()}");
            }
            $zip->close();
        }

        foreach ($files as $file) {
            File::delete($file->getRealPath());
        }

        return url('rob18n-lang.zip');
    }
}
