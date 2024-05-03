<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LendingBookRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
            'return_date' => 'date'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isEmpty()) {
                    $user = User::whereId($validator->safe()->user_id)->first();
                    $book = Book::whereId($validator->safe()->book_id)->first();

                    if(is_null($user))
                    {
                        $validator->errors()->add(
                            'user_id',
                            'O usuario não foi encontrado.'
                        );
                    }

                    if(is_null($book))
                    {
                        $validator->errors()->add(
                            'book_id',
                            'O livro não foi encontrado.'
                        );
                    }
                }
            }
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 400));
    }
}
