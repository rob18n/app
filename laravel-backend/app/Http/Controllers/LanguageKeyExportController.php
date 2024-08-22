<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportLanguagesRequest;
use App\Models\Language;
use App\Models\LanguageKey;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class LanguageKeyExportController extends Controller
{
    public function export(ExportLanguagesRequest $request)
    {
        $format = $request->format;
        $languages = json_decode($request->languages, true);
        $selectedLanguages = Arr::flatten($languages);
        $languages = Language::whereIn('shortkey', $selectedLanguages)->get()->pluck('id', 'shortkey')->toArray();
        $dataForFile = collect([]);

        foreach ($languages as $shortKey => $id) {
            $dataForFile[$id] = collect([
                'shortKey' => $shortKey,
                'entries' => collect([])
            ]);
        }

        $keys = LanguageKey::with(['values' => function ($query) use ($languages) {
            $query->whereIn('language_id', $languages);
        }])->get();

        foreach ($keys as $key) {
            foreach ($key->values as $value) {
                $dataForFile[$value->language_id]['entries']->put($key->key, $value->value);
            }
        }

        switch ($format) {
            case ('json'):
                $dataForFile->each(function ($item) {
                    $shortKey = $item->get('shortKey');
                    $entries = $item->get('entries');

                    $jsonContent = $entries->toJson(JSON_PRETTY_PRINT);

                    $filePath = storage_path("app/{$shortKey}.json");
                    File::put($filePath, $jsonContent);
                });
            default:
                break;
        }

        $zipUrl = LanguageKey::zip($dataForFile, $format);
        return response()->json($zipUrl, Response::HTTP_OK);
    }
}
