<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectLanguageKeyRequest;
use App\Http\Requests\UpdateProjectLanguageKeyRequest;
use App\Models\LanguageKey;
use App\Models\LanguageKeyValue;
use App\Models\ProjectLanguage;
use Illuminate\Http\Response;

class ProjectLanguageKeyController extends Controller
{
    public function index()
    {
        $projectLanguages = LanguageKey::all();
        return response()->json($projectLanguages);
    }

    public function store(StoreProjectLanguageKeyRequest $request)
    {
        $values = collect();
        $languageKey = LanguageKey::create([
            'project_id' => $request->id,
            'key' => $request->key,
            'description' => $request->description
        ]);

        foreach (collect(json_decode($request->values))->toArray() as $languageId => $value) {
            if ($value) {
                $entry = LanguageKeyValue::create([
                    'language_id' => $languageId,
                    'language_key_id' => $languageKey->id,
                    'value' => $value
                ]);

                $values->push($entry);
            }
        }

        $languageKey->value = $values;

        return response()->json($languageKey, 201);
    }

    public function show($id)
    {
        $projectLanguage = ProjectLanguage::where('id', $id)->with('keys', 'languages')->first();

        if (!$projectLanguage) {
            return response()->json(['message' => 'ProjectLanguage not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($projectLanguage, Response::HTTP_OK);
    }

    public function update(UpdateProjectLanguageKeyRequest $request, $id)
    {
        $projectLanguage = ProjectLanguage::find($id);

        if (!$projectLanguage) {
            return response()->json(['message' => 'ProjectLanguage not found'], Response::HTTP_NOT_FOUND);
        }

        $projectLanguage->update($request->validated());

        return response()->json($projectLanguage, Response::HTTP_OK);
    }


    public function destroy($id)
    {
        $projectLanguage = ProjectLanguage::find($id);

        if (!$project) {
            return response()->json(['message' => 'projectLanguage not found'], Response::HTTP_NOT_FOUND);
        }

        $projectLanguage->delete();

        return response()->json(['message' => 'projectLanguage deleted'], Response::HTTP_OK);
    }
}
