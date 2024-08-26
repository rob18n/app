<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddLanguageToProjectRequest;
use App\Http\Requests\DeleteProjectLanguageRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Models\LanguageKey;
use App\Models\LanguageKeyValue;
use App\Models\Project;
use App\Models\ProjectLanguage;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    // Display a listing of the projects
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects, Response::HTTP_OK);
    }

    // Store a newly created project in storage
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        foreach (json_decode($request->selectedLanguages) as $language) {
            ProjectLanguage::create([
                'project_id' => $project->id,
                'language_id' => $language->id,
                'primary' => $language->primary
            ]);
        }

        return response()->json($project, Response::HTTP_CREATED);
    }


    // Display the specified project
    public function show($id)
    {
        $project = Project::where('id', $id)->with('keys', 'keys.values', 'keys.values.language', 'languages')->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($project, Response::HTTP_OK);
    }

    // Update the specified project in storage
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->update($request->validated());

        return response()->json($project, Response::HTTP_OK);
    }

    // Remove the specified project from storage
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted'], Response::HTTP_OK);
    }

    public function addLanguage(AddLanguageToProjectRequest $request)
    {
        $project = Project::where('id', $request->project_id)->with('keys')->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $projectLanguage = ProjectLanguage::create([
            'project_id' => $request->project_id,
            'language_id' => $request->language_id,
            'primary' => 0
        ]);

        foreach ($project->keys as $key) {
            LanguageKeyValue::create([
                'value' => '',
                'language_id' => $request->language_id,
                'language_key_id' => $key->id
            ]);
        }

        $updatedProject = Project::where('id', $request->project_id)->with('keys', 'keys.values', 'keys.values.language', 'languages')->first();

        return response()->json($updatedProject, Response::HTTP_OK);
    }

    public function destroyLanguage(DeleteProjectLanguageRequest $request)
    {
        $project = Project::where('id', $request->project_id)->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $projectLanguage = $project->languages->where('id', $request->language_id)->first();
        $projectLanguage->delete();

        $keys = LanguageKey::where('project_id', $request->project_id)->whereHas('values', function (Builder $query) use ($request) {
            $query->where('language_id', $request->language_id);
        })->get();

        foreach ($keys as $key) {
            foreach ($key->values as $value) {
                $value->delete();
            }
        }

        $updatedProject = Project::where('id', $request->project_id)->with('keys', 'keys.values', 'keys.values.language', 'languages')->first();

        return response()->json($updatedProject, Response::HTTP_OK);
    }
}
