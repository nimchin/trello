<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Board;
use Validator;

class BoardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $boards = Board::all();

        return $this->sendResponse($boards->toArray(), 'Boards retrieved successfully.');
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

        $input = $this->validateBoard($input);

        $validator = Validator::make($input, [
            'author_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $board = Board::create($input);

        return $this->sendResponse($board->toArray(), 'Board created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Board $board)
    {
        $input = $request->all();

        $input = $this->validateBoard($input);

        $validator = Validator::make($input, [
            'author_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $board->save();

        return $this->sendResponse($board->toArray(), 'Board updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Board $board)
    {
        $board->delete();

        return $this->sendResponse($board->toArray(), 'Board deleted successfully.');
    }

    /**
     * Validating board model
     * @param array $input
     * @return array
     */
    private function validateBoard(array $input)
    {
        if(isset($input['name']) && $input['name']) {
            $input['name'] = strip_tags($input['name']);
        }
        if(isset($input['author_id']) && $input['author_id']) {
            $input['author_id'] = (int)$input['author_id'];
        }
        return $input;
    }
}
