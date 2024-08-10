<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectLanguageKeyValueRequest;
use App\Models\LanguageKeyValue;
use Illuminate\Http\Response;

class ProjectLanguageKeyValueController extends Controller
{
    public function update(UpdateProjectLanguageKeyValueRequest $request, $id)
    {
        $variable = LanguageKeyValue::find($id);

        if (!$variable) {
            return response()->json(['message' => 'Variable not found'], Response::HTTP_NOT_FOUND);
        }

        $variable->update($request->validated());

        return response()->json($variable, Response::HTTP_OK);
    }
}
