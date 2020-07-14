<?php

namespace App\Http\Controllers\API;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;
use Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::paginate($this->paginationSettings['per_page']);

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $input = $this->validateTask($input);

        $validator = Validator::make($input, [
            'name' => 'required',
            'board_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::create($input);

        return $this->sendResponse($task->toArray(), 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $input = $this->validateTask($input);

        if(is_null($task = Task::find((int)$id))) {
            return $this->sendError('Task not found.');
        }

        $task->update($input);

        return $this->sendResponse($task->toArray(), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return $this->sendResponse($task->toArray(), 'Task deleted successfully.');
    }

    /**
     * Validation task model
     *
     * @param array $input
     */
    private function validateTask(array $input){
        if(isset($input['name']) && $input['name']) {
            $input['name'] = strip_tags($input['name']);
        }
        if(isset($input['board_id']) && $input['board_id']){
            $input['board_id'] = (int)$input['board_id'];
        }
        if(isset($input['img_path']) && $input['img_path']) {
            $input['img_path'] = strip_tags($input['img_path']);
        }
        if(isset($input['status']) && $input['status']) {
            $input['status'] = strip_tags($input['status']);
        }
        return $input;
    }
}