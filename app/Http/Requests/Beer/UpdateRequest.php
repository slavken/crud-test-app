<?php

namespace App\Http\Requests\Beer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('beers', 'name')
                    ->ignore($this->beer->id),
                'min:2',
                'max:255',
            ],
            'desc' => 'required',
            'img' => 'mimes:png,jpg,jpeg|max:4096',
        ];
    }
}
