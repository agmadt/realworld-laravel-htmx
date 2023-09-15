<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SettingUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image_url' => 'required',
            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')->ignore(auth()->user()->id)],
            'bio' => 'nullable',
            'password' => 'nullable'
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $response = response()->view('components.form-error-message', [
            'errors' => $validator->errors()
        ])
        ->withHeaders([
            'HX-Reswap' => 'innerHTML show:top',
            'HX-Retarget' => '#settings-form-message'
        ]);

        throw new HttpResponseException($response);
    }
}
