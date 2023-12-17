<?php

namespace App\Rules;

use App\Models\Division;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DivisionAllowedRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existDivision = Division::where('id', $value)->exists();
        if (!$existDivision) {
            $fail('The :attribute must be exist');
        }
    }
}
