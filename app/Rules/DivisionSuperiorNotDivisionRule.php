<?php

namespace App\Rules;

use App\Models\Division;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DivisionSuperiorNotDivisionRule implements ValidationRule
{
    public function __construct(private int $id)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === $this->id) {
            $fail('The :attribute not must be equal to id');
        }
        $division = Division::find($value);
        if ($division) {
            $divisionSuperiorId = $division->division_superior_id;

            if ($this->id === $divisionSuperiorId) {
                $fail('The :attribute not can be division superior');
            }
        }
    }
}
