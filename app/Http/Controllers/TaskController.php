<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        if($request->itemsPerPage === '-1'){
            $request->itemsPerPage = Task::count();
        }

        $tasksQuery = Task::select();

        if ($request->with) {
            $tasksQuery->with($request->with);
        }

        if ($request->date) {
            $tasksQuery->whereDate('date', $request->date);
        }

        if (!auth()->user()->adm) {
          $tasksQuery->where('user_id', auth()->user()->id);  
        }

        if(isset($request->sortBy)) {
            for ($i = 0; $i < count($request->sortBy); $i++) {
                $tasksQuery->orderBy($request->sortBy[$i], ($request->sortDesc[$i] === 'true') ? 'DESC' : 'ASC');
            }
        }
        else{
            $tasksQuery->orderBy('id', 'DESC');
        }

        if($request->search){
            $search = explode(' ', $request->search);
            foreach ($search as $valSearch) {
                $tasksQuery->where('title', 'LIKE', "%" . $valSearch . "%");
            }
        }

        $tasks = $tasksQuery->paginate($request->itemsPerPage ?? 25);
        return response()->json($tasks, 200);
    }

    public function store(TaskRequest $request) : JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $task = Task::create($data);

        return  response()->json($task, 201);
    }

    public function show(Task $task) : JsonResponse
    {
        return response()->json($task, 200);
    }

    public function update(TaskRequest $request, Task $task) : JsonResponse
    {
        $data = $request->all();

        $task->update($data);

        return  response()->json($task, 201);
    }

    public function destroy(Task $task) : JsonResponse
    {
        $task->delete();

        return response()->json([], 200);
    }
}
