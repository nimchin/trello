<?php

namespace App\Http\Requests\Task;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', $this->route()->parameter('task'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => Rule::in(['done', 'in progress']),
            'author_id' => 'required|exists:users,id'
        ];
    }

    public function prepareForValidation()
    {
        $attributes = [];
        if($this->id) {
            $attributes['id'] = (int)$this->id;
        }
        if($this->name){
            $attributes['name'] = strip_tags($this->name);
        }
        if($this->board_id){
            $attributes['board_id'] = (int)$this->board_id;
        }
        if($this->user_id){
            $attributes['user_id'] = (int)$this->user_id;
        }
        if($this->status){
            $attributes['status'] = strip_tags($this->status);
        }
        if($this->author_id){
            $attributes['author_id'] = (int)$this->author_id;
        } else {
            $attributes['author_id'] = auth()->user()->id;
        }
        $this->merge($attributes);
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return ['author_id.exists' => 'Not existing user with provided id'];
    }
}
