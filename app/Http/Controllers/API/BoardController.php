<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Board\CreateBoard;
use App\Http\Requests\Board\UpdateBoard;
use App\Http\Resources\BoardResource;
use App\Http\Resources\BoardsCollection;
use App\MongoLog;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Board;
use Illuminate\Http\JsonResponse;


class BoardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse(new BoardsCollection(Board::paginate(config('pagination.per_page'))));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBoard $request
     * @return JsonResponse
     */
    public function store(CreateBoard $request)
    {
        $board = Board::create($request->all());

        MongoLog::create([
            'crud_type'     => 'create',
            'entity_type'   => 'board',
            'entity_id'     => $board->id,
            'message'       => 'Board was created!',
            'author_id'     => auth()->user()->id
        ]);

        return $this->sendResponse(new BoardResource($board));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->sendResponse(new BoardResource(Board::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBoard $request
     * @param Board $board
     * @return JsonResponse
     */
    public function update(UpdateBoard $request, Board $board)
    {
        $board->update($request->all());

        MongoLog::create([
            'crud_type'     => 'update',
            'entity_type'   => 'board',
            'entity_id'     => $board->id,
            'message'       => 'Board was updated!',
            'author_id'     => auth()->user()->id
        ]);

        return $this->sendResponse(new BoardResource($board));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Board $board
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Board $board)
    {
        $board->delete();

        MongoLog::create([
            'crud_type'     => 'delete',
            'entity_type'   => 'board',
            'entity_id'     => $board->id,
            'message'       => 'Board was deleted!',
            'author_id'     => auth()->user()->id
        ]);

        return $this->sendResponse(new BoardResource($board));
    }

}
