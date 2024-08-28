<?php

namespace App\Http\Controllers;

use App\Models\LanguageKey;
use App\Models\LanguageKeyValue;
use App\Models\Project;
use Illuminate\Http\Request;

class LanguageKeyImportController extends Controller
{
    public function upload(Request $request)
    {
        $files = $request->file('files');
        $languages = $request->input('files');
        $project = Project::where('id', $request->project_id)->first();

        $mappedLanguages = collect(array_map(function ($item) {
            return (int) $item['language'];
        }, $languages));

        $projectLanguageIds = $project->languages->pluck('id');
        $missingLanguageIds = $projectLanguageIds->diff($mappedLanguages);
        $processedData = [];

        foreach ($files as $index => $fileData) {
            $file = $fileData['file'];
            $language = $languages[$index]['language'] ?? null;

            if (!$language) {
                return response()->json(['message' => 'Language not provided for one of the files.'], 400);
            }

            $extension = $file->getClientOriginalExtension();
            $content = file_get_contents($file->getRealPath());

            if ($extension === 'json') {
                $decodedContent = json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['message' => 'Invalid JSON format.'], 400);
                }

                $processedData[] = [
                    'language' => $language,
                    'variables' => $decodedContent
                ];
            } elseif ($extension === 'php') {
                $decodedContent = $this->parsePhpContent($content);

                if (!is_array($decodedContent)) {
                    return response()->json(['message' => 'Invalid PHP format. Expected an array.'], 400);
                }

                // Flache Struktur für verschachtelte Arrays erzeugen
                $flattenedContent = $this->flattenArray($decodedContent);

                $processedData[] = [
                    'language' => $language,
                    'variables' => $flattenedContent
                ];
            } else {
                return response()->json(['message' => 'Unsupported file format.'], 400);
            }
        }

        foreach ($processedData as $dataEntry) {
            foreach ($dataEntry['variables'] as $key => $value) {
                $languageKey = LanguageKey::firstOrNew([
                    'project_id' => $request->project_id,
                    'key' => $key
                ]);

                $languageKey->description = $languageKey->description ?? '';
                $languageKey->save();

                $variable = LanguageKeyValue::firstOrNew([
                    'language_id' => $dataEntry['language'],
                    'language_key_id' => $languageKey->id
                ]);

                $variable->value = $value;
                $variable->save();
            }
        }

        if (count($missingLanguageIds)) {
            $languageVariableIds = LanguageKey::where('project_id', $request->project_id)->get()->pluck('id');

            foreach ($missingLanguageIds as $missingLanguageId) {
                foreach ($languageVariableIds as $languageVariableId) {
                    $missingValue = new LanguageKeyValue();
                    $missingValue->language_id = $missingLanguageId;
                    $missingValue->language_key_id = $languageVariableId;
                    $missingValue->value = '';
                    $missingValue->save();
                }
            }
        }

        return response()->json(['message' => 'Files uploaded successfully.'], 200);
    }

    private function parsePhpContent($content)
    {
        $tmpFilePath = storage_path('tmp_php_file.php');
        file_put_contents($tmpFilePath, $content);

        $data = include $tmpFilePath;

        unlink($tmpFilePath);

        return $data;
    }

    private function flattenArray(array $array, $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '.' . $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }
}
