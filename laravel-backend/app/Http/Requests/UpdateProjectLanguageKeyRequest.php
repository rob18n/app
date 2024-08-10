<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectLanguageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'key' => 'sometimes|required|string|max:255',
            'project_id' => 'sometimes|required|exists:projects,id',
        ];
    }
}
