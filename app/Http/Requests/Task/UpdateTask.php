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
        $id = $this->route('id') || $this->id;
        $task = Task::find((int)$id);

        return auth()->user()->can('update', $task);
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
        $this->merge($attributes);
    }
}
