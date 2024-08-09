<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteUpdateRequest extends FormRequest
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
            'server_id' => ['required', 'exists:servers,id'],
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'url', 'max:255'],
            'admin_email' => ['required', 'email:strict', 'max:255'],
            'site_path' => ['required', 'string', 'max:255'],
        ];
    }
}
