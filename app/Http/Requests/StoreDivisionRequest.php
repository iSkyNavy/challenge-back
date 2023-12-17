<?php

namespace App\Http\Requests;

use App\Rules\DivisionAllowedRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionRequest extends FormRequest
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
            'name' => 'required|string|max:45|unique:divisions,name,' . $this->route('id'),
            'ambassador_name' => 'string',
            'division_superior_id' => ['integer', new DivisionAllowedRule()]
        ];
    }
}
