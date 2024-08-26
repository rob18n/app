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

    protected $appends = ['statistics'];

    public function keys()
    {
        return $this->hasMany(LanguageKey::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'project_languages', 'project_id', 'language_id');
    }

    public function getStatisticsAttribute()
    {
        $values = $this->keys()->with('values')->get()->pluck('values')->flatten();
        $statistics = collect();
        $languageCoverage = collect();
        $totalWordCount = 0;
        $variableCount = $this->keys->count();

        foreach ($this->languages as $language) {
            $entry = collect([]);
            $entry->put('id', $language->id);
            $entry->put('name', $language->shortkey);
            $entry->put('filled', 0);
            $entry->put('unfilled', 0);
            $entry->put('entries', 0);
            $entry->put('wordCount', 0);
            $entry->put('coverage', 0);

            $languageCoverage->push($entry);
        }

        foreach ($values as $value) {
            $wordCount = str_word_count($value->value);
            $totalWordCount = $totalWordCount + $wordCount;

            $languageEntry = $languageCoverage->where('id', $value->language_id)->first();

            $value->value != '' ? $languageEntry['filled'] = $languageEntry['filled'] + 1 : $languageEntry['unfilled'] = $languageEntry['unfilled'] + 1;
            $languageEntry['entries'] = $languageEntry['entries'] + 1;
            $languageEntry['wordCount'] = $languageEntry['wordCount'] + $wordCount;
        }

        foreach ($languageCoverage as $coverage) {
            $coverage['coveragePercent'] = $variableCount ? round((($coverage['filled'] - $coverage['unfilled']) / $variableCount) * 100, 2) : 0;
        }

        $lowestCoverage = $languageCoverage->sortByDesc('unfilled')->first();
        $coveragePercent = $variableCount ? (($lowestCoverage['filled'] - $lowestCoverage['unfilled']) / $variableCount) * 100 : 0;

        $statistics->put('wordCount', $totalWordCount);
        $statistics->put('languageCoverage', $languageCoverage);
        $statistics->put('variables', $variableCount);
        $statistics->put('coveragePercent', round($coveragePercent, 2));

        return $statistics;
    }
}
