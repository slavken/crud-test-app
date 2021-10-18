<?php

namespace App\Http\Requests\Beer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|unique:beers|min:2|max:255',
            'desc' => 'required',
            'img' => 'required|mimes:png,jpg,jpeg|max:4096',
        ];
    }
}
