<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BestSellersSearchRequest extends FormRequest
{
    private const array ALLOWED_FIELDS_TO_QUERY_BY = ['author', 'isbn', 'title', 'offset'];
    public function rules(): array
    {
        return [
            'author' => 'nullable|string',
            'isbn' => 'nullable|array',
            'title' => 'nullable|string',
            'offset' => 'nullable|integer',
            '_unexpected' => 'nullable|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $inputFields = array_keys($this->all());

        foreach ($inputFields as $field) {
            if (!in_array($field, self::ALLOWED_FIELDS_TO_QUERY_BY)) {
                $this->merge(['_unexpected' => $field]);
            }
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        foreach ($validator->errors()->getMessages() as $msg) {
            throw new HttpResponseException(response()->json($msg[0]));
        }
    }
}
