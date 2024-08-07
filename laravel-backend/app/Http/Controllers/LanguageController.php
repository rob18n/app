<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Response;

class LanguageController extends Controller
{
    // Display a listing of the languages
    public function index()
    {
        $languages = Language::all();
        return response()->json($languages, Response::HTTP_OK);
    }

    // Store a newly created language in storage
    public function store(StoreLanguageRequest $request)
    {
        $language = Language::create($request->validated());

        return response()->json($language, Response::HTTP_CREATED);
    }

    // Display the specified language
    public function show($id)
    {
        $language = Language::find($id);

        if (!$language) {
            return response()->json(['message' => 'Language not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($language, Response::HTTP_OK);
    }

    // Update the specified language in storage
    public function update(UpdateLanguageRequest $request, $id)
    {
        $language = Language::find($id);

        if (!$language) {
            return response()->json(['message' => 'Language not found'], Response::HTTP_NOT_FOUND);
        }

        $language->update($request->validated());

        return response()->json($language, Response::HTTP_OK);
    }

    // Remove the specified language from storage
    public function destroy($id)
    {
        $language = Language::find($id);

        if (!$language) {
            return response()->json(['message' => 'Language not found'], Response::HTTP_NOT_FOUND);
        }

        $language->delete();

        return response()->json(['message' => 'Language deleted'], Response::HTTP_OK);
    }
}
