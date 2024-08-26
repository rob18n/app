<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLanguageToProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_id' => 'required',
            'language_id' => 'required',
        ];
    }
}
