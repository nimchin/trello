<?php

namespace App\Http\Resources;

use App\Board;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class BoardStatisticCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        foreach($this->collection as $board) {
            $allTasks = $board->tasks;
            $doneTasks = $allTasks->where('status', '=', 'done');
            $mostActiveUser = DB::table('tasks')
                ->select(DB::raw('count(user_id) as done_task, user_id'))
                ->where('status', '=', 'done')
                ->whereIn('id', $board->tasks()->pluck('id'))
                ->orderByDesc('done_task')
                ->groupBy('user_id')
                ->having('done_task', '>', 1)
                ->limit(1)
                ->get();
            if(count($doneTasks))
                $progress = $doneTasks->count() / $allTasks->count() * 100;
            $boardsCollection[] = array(
                'board_id' => $board->id,
                'total_tasks' => $allTasks->count(),
                'done_tasks' => $doneTasks->count(),
                'progress' => (int)($progress ?? 0),
                'most_active_user' => $mostActiveUser,
            );
        }

        return [
            'collection' => $boardsCollection ?? [],
        ];
    }
}
