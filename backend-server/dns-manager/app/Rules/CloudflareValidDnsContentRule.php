<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CloudflareValidDnsContentRule implements ValidationRule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type = $this->data['type'] ?? null;

        if ($type === 'A' && !filter_var($value, FILTER_VALIDATE_IP)) {
            $fail("The $attribute must be a valid IP address.");
        }

        if ($type === 'CNAME' && !preg_match('/^[a-zA-Z0-9-_.]+$/', $value)) {
            $fail("The $attribute must be a valid CNAME record.");
        }

        if ($type === 'TXT' && !preg_match('/^[a-zA-Z0-9-_.]+$/', $value)) {
            $fail("The $attribute must be a valid TXT record.");
        }
    }

    /**
     * Set the data under validation.
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
