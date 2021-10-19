<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZipStorePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['min:3', 'max:20', 'required'],
        ];
    }
}
