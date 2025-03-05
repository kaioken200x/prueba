<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;
use Barryvdh\DomPDF\Facade as PDF;
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
            ->setPaper('A4', 'portrait');
    
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

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $project = Project::find($request->project_id);
        if ($project && $project->user_id != $request->user_id) {
            $project->user_id = $request->user_id;
            $project->save();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'start_datetime' => 'required|date_format:Y-m-d\TH:i',
            'end_datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:start_datetime',
        ]);

        $task = Task::findOrFail($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->start_datetime = $request->start_datetime;
        $task->end_datetime = $request->end_datetime;
        $task->save();

        return response()->json($task);
    }

    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(null, 204);
    }
}
