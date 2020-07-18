<?php

namespace App\Http\Requests\Board;

use App\Board;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBoard extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', $this->route()->parameter('board'));
    }

    public function prepareForValidation()
    {
        $attributes = [];
        if($this->author_id){
            $attributes['author_id'] = (int)$this->author_id;
        } else {
            $attributes['author_id'] = auth()->user()->id;
        }
        $this->merge($attributes);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'author_id' => 'required|exists:users,id'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return ['author_id.exists' => 'Not existing user with provided id'];
    }
}
