<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required',
            'email' => 'required|email|unique:wishes,email',
            'phoneNumber' => 'required',
            'content' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }



    public function messages()
    {
        return [
            'name.required' => 'Név megadása kötelező!',
            'email.required' => 'Email cím megadása kötelező!',
            'email.unique' => 'Ezzel az email címmel már regisztráltak!',
            'phoneNumber.required' => 'Telefonszám megadása kötelező!',
            'content.required' => 'Kívánságlista megadása kötelező!'
        ];
    }
}
