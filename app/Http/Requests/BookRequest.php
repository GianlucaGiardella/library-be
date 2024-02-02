<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        $bookId = $this->route('book');
        $routeName = $this->route()->getName();

        if ($routeName === 'books.add') {
            return ['readings'    => 'required|integer|min:0'];
        }

        return [
            'title'       => 'required|string|min:1|max:80',
            'author'      => 'required|string|min:2|max:50',
            'isbn_code'   => 'required|numeric|regex:/^(\d{13})?$/|' . Rule::unique('books')->ignore($bookId),
            'plot'        => 'required|string|min:5',
            'readings'    => 'required|integer|min:0',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
