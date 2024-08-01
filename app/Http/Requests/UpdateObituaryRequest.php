<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateObituaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'dateOfBirth' => 'required|date',
            'dateOfDeath' => 'required|date',
            'permanentAddress' => 'required|string',
            'temporaryAddress' => 'required|string',
            'dateOfStartView' => 'required|date',
            'dateOfEndView' => 'required|date',
            'dateOfDeathDeeds' => 'required|date',
            'dateOfCremation' => 'required|date',
            'furtherAnnouncement' => 'required|string',
            'adStartDate' => 'required|date',
            'adEndDate' => 'required|date',

        ];
    }
}