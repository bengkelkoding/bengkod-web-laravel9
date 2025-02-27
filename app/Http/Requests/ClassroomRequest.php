<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_course' => 'numeric',
            'id_lecture' => 'numeric',
            'name' => 'string',
            'description' => 'string',
            'day' => 'string',
            'time' => 'string',
            'quota' => 'numeric',
        ];
    }
}
