<?php

namespace App\Http\Controllers\API;

use App\Jobs\ImageCropping;
use App\MongoLog;
use App\Services\ImagickPhotoService;
use App\Services\PhotoService;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;
use Imagick;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

//        $input = $request->all();
//
//        $input = $this->validateTask($input);
//        $input['author_id'] = auth()->user()->id;
//
//        $validator = Validator::make($input, [
//            'name' => 'required',
//            'board_id' => 'required',
//        ]);
//
//        if($validator->fails()){
//            return $this->sendError('Validation Error.', $validator->errors());
//        }
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');

            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            if(!is_dir($destinationPath)){
                mkdir($destinationPath,0777,true);
                chmod($destinationPath, 0777);
            }
            $image->move($destinationPath, $name);
            $input['img_path'] = $destinationPath . '/' . $name;

            dispatch(new ImageCropping($destinationPath, $name));

        }
//
//        $task = Task::create($input);
//
//        MongoLog::create([
//            'crud_type'     => 'create',
//            'entity_type'   => 'task',
//            'entity_id'     => $task->id,
//            'message'       => 'Task was created!',
//            'author_id'     => auth()->user()->id
//        ]);

        return $this->sendResponse('$task', 'Task created successfully.');
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

        $input['author_id'] = auth()->user()->id;

        if(is_null($task = Task::find((int)$id))) {
            return $this->sendError('Task not found.');
        }

        $task->update($input);

        MongoLog::create([
            'crud_type'     => 'update',
            'entity_type'   => 'task',
            'entity_id'     => $task->id,
            'message'       => 'Task was updated!',
            'author_id'     => auth()->user()->id
        ]);

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

        MongoLog::create([
            'crud_type'     => 'delete',
            'entity_type'   => 'task',
            'entity_id'     => $task->id,
            'message'       => 'Task was deleted!',
            'author_id'     => auth()->user()->id
        ]);

        return $this->sendResponse($task->toArray(), 'Task deleted successfully.');
    }

    /**
     * Validation task model
     *
     * @param array $input
     */
    private function validateTask(array $input)
    {
        if(isset($input['name']) && $input['name']) {
            $input['name'] = strip_tags($input['name']);
        }
        if(isset($input['board_id']) && $input['board_id']){
            $input['board_id'] = (int)$input['board_id'];
        }
        if(isset($input['user_id']) && $input['user_id']) {
            $input['user_id'] = (int)$input['user_id'];
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
