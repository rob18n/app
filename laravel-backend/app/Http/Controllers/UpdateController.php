<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller
{
    public function checkUpdates()
    {
        $url = 'https://api.github.com/repos/' . config('app.github.owner') . '/' . config('app.github.repo') . '/releases';

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
        ])->get($url);

        $data = $response->json();
        $gitVersion = $data[0]['tag_name'];

        $responseData = collect([]);
        $responseData->put('update_required', version_compare(config('app.version'), $gitVersion) < 0);
        $responseData->put('current_version', config('app.version'));
        $responseData->put('git_version', $gitVersion);

        return response()->json($responseData, Response::HTTP_OK);
    }
}
