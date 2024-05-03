<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $user = User::where([
                    'email' => $validator->safe()->email
                ])->first();
        
                if(!password_verify($validator->safe()->password, $user->password))
                {
                    $validator->errors()->add(
                        'email',
                        'The e-mail is invalid.'
                    );

                    $validator->errors()->add(
                        'password',
                        'The password is invalid.'
                    );
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
