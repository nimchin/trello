<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Task\CreateTask;
use App\Http\Requests\Task\UpdateTask;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Jobs\ImageCropping;
use App\MongoLog;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse(new TaskCollection(Task::paginate(config('pagination.per_page'))));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTask $request
     * @return JsonResponse
     */
    public function store(CreateTask $request)
    {
        $input = $request->all();

        $input['author_id'] = auth()->user()->id;

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

        $task = Task::create($input);

        MongoLog::create([
            'crud_type'     => 'create',
            'entity_type'   => 'task',
            'entity_id'     => $task->id,
            'message'       => 'Task was created!',
            'author_id'     => auth()->user()->id
        ]);

        return $this->sendResponse(new TaskResource($task));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        return $this->sendResponse(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTask $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(UpdateTask $request, Task $task)
    {
        $task->update($request->all());

        MongoLog::create([
            'crud_type'     => 'update',
            'entity_type'   => 'task',
            'entity_id'     => $task->id,
            'message'       => 'Task was updated!',
            'author_id'     => auth()->user()->id
        ]);

        return $this->sendResponse(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
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

        return $this->sendResponse(new TaskResource($task));
    }

}
