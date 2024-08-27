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
        $publicPath = public_path('rob18n-lang');
        $zipFilePath = public_path('rob18n-lang.zip');

        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0755, true);
        }

        $fileData->each(function ($item) use ($publicPath, $format) {
            $shortKey = $item->get('shortKey');
            $entries = $item->get('entries');
            $filePath = "{$publicPath}/{$shortKey}.{$format}";

            switch ($format) {
                case 'json':
                    $content = $entries->toJson(JSON_PRETTY_PRINT);
                    File::put($filePath, $content);
                    break;

                case 'php':
                    $nestedArray = [];
                    foreach ($entries as $key => $value) {
                        self::setNestedArrayValue($nestedArray, explode('.', $key), $value);
                    }
                    $content = "<?php\n\nreturn " . var_export($nestedArray, true) . ";\n";
                    File::put($filePath, $content);
                    break;

                default:
                    throw new \Exception("Unsupported format: $format");
            }
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

    static private function setNestedArrayValue(&$array, $keys, $value)
    {
        foreach ($keys as $key) {
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array = $value;
    }
}
