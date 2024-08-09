<?php

namespace App\Rules;

use App\Services\CloudflareService\CloudflareService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidCloudflareAPITokenRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cloudflareService = new CloudflareService(token: $value);

        if (!$cloudflareService->isValidApiToken()) {
            $fail('The :attribute is not valid.');
        }
    }
}
