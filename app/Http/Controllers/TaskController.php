<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;

use Log;

class TaskController extends Controller {
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;

    const BAD_REQUEST = 400;

    public function index() {
        $tasks = Task::where('is_deleted', 0)->get();

        return response()->json(['tasks' => $tasks] , self::OK);
    }

    public function show($id) {
        $task = Task::where('is_deleted', 0)
                    ->where('id', $id)
                    ->get()
                    ->first();

        return response()->json(['task' => $task], self::OK);
    }

    public function store(Request $request) {
        $response = response()->json(['error' => 'missing required field'], self::BAD_REQUEST);

        $title = $request->input('task.title');
        
        if($title) {
            $task = Task::create($request->input('task'));
            $response = response()->json(['task' => $task], self::CREATED);
        }
        
        return $response;
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);
        $task->update($request->input('task'));

        return response()->json(['task' => $task], self::OK);
    }

    public function delete(Request $request, $id) {
        $task = Task::findOrFail($id);
        $task['is_deleted'] = true;
        $task->save();

        return response()->json(null, self::NO_CONTENT);
    }
}
