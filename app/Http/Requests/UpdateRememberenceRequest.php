<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRememberenceRequest extends FormRequest
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
            'dateOfDeath' => 'required|date',
            'address' => 'required|string',
            'rememberanceDay' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'furtherAnnouncement' => 'required|string',
            // 'contactName' => 'required|string',
            // 'contactNumber' => ['required', 'string', 'regex:/^\+?[0-9]{1,15}$/'],
            'adStartDate' => 'required|date',
            'adEndDate' => 'required|date',
        ];
    }
}