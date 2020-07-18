<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Board\CreateBoard;
use App\Http\Requests\Board\UpdateBoard;
use App\Http\Resources\BoardsCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Board;
use Validator;

class BoardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return BoardsCollection
     */
    public function index()
    {
        return new BoardsCollection(Board::paginate(config('pagination.per_page')));
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

        return $this->sendResponse($board->toArray(), 'Board created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $board = Board::find($id);

        if (is_null($board)) {
            return $this->sendError('Board not found.');
        }

        return $this->sendResponse($board->toArray(), 'Board retrieved successfully.');
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

        return $this->sendResponse($board->toArray(), 'Board updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Board $board)
    {
        $board->delete();

        return $this->sendResponse($board->toArray(), 'Board deleted successfully.');
    }

}
