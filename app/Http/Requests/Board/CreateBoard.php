<?php

namespace App\Http\Requests\Board;

use App\Board;
use Illuminate\Foundation\Http\FormRequest;

class CreateBoard extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', Board::class);
    }

    /**
     *
     */
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
            'author_id' => 'required',
        ];
    }
}
