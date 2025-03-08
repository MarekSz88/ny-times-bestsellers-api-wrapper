<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestSellersSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'author' => 'string',
            'isbn' => 'array',
            'title' => 'string',
            'offset' => 'integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
