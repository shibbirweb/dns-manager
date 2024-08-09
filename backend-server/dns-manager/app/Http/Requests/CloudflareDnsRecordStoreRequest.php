<?php

namespace App\Http\Requests;

use App\Rules\CloudflareValidDnsContentRule;
use App\Services\CloudflareService\Enums\DnsRecordTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CloudflareDnsRecordStoreRequest extends FormRequest
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
            'type' => ['required', 'string', Rule::enum(DnsRecordTypeEnum::class)],
            'name' => ['required', 'string'],
            'content' => ['required', 'string', new CloudflareValidDnsContentRule()],
        ];
    }
}
