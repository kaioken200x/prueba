<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function report(Request $request)
    {
        $tasks = Task::where('end_datetime', '<', Carbon::now())
            ->with('project.user')
            ->filter($request->all())
            ->get();
    
        $tasks = $tasks->map(function ($task) {
            $task->minutes = Carbon::parse($task->start_datetime)
                ->diffInMinutes(Carbon::parse($task->end_datetime));
            return $task;
        });
    
        $pdf = PDF::loadView('tasks.report', compact('tasks'))
            ->setOption('encoding', 'UTF-8');
    
        return $pdf->download('report.pdf');
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'start_datetime' => 'required|date_format:Y-m-d\TH:i',
            'end_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_datetime',
        ]);

        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->start_datetime = $request->start_datetime;
        $task->end_datetime = $request->end_datetime;
        $task->save();

        $task = $task->fresh();
        $task->name = utf8_encode($task->name);
        $task->description = utf8_encode($task->description);

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'start_datetime' => 'required|date_format:Y-m-d\TH:i',
            'end_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_datetime',
        ]);

        $task = Task::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->start_datetime = $request->start_datetime;
        $task->end_datetime = $request->end_datetime;
        $task->save();

        $task = $task->fresh();
        $task->name = utf8_encode($task->name);
        $task->description = utf8_encode($task->description);

        return response()->json($task);
    }
}
