<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
        $contact = $this->route('contact');

        return [
            'name' => [
                'required',
                'string',
                'min:5',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('contacts', 'email')
                    ->ignore($contact->id)
                    ->whereNull('deleted_at'),
            ],
            'contact' => [
                'required',
                'digits:9',
                Rule::unique('contacts', 'contact')
                    ->ignore($contact->id)
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
