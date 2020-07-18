<?php

namespace App\Http\Requests\Task;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', Task::class);
    }

    public function prepareForValidation()
    {
        $attributes = [];
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
            'name' => 'required',
            'board_id' => 'required',
            'status' => Rule::in(['done', 'in progress']),
        ];
    }
}
