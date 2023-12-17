<?php

namespace App\Http\Requests;

use App\Rules\DivisionAllowedRule;
use App\Rules\DivisionSuperiorNotDivision;
use App\Rules\DivisionSuperiorNotDivisionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateDivisionRequest extends FormRequest
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
            'name' => 'string|max:45|unique:divisions,name,' . $this->route('id'),
            'ambassador_name' => ['string', 'nullable'],
            'division_superior_id' => ['integer', 'nullable', new DivisionAllowedRule(), new DivisionSuperiorNotDivisionRule($this->route('id'))]
        ];
    }
}
