<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function complate()
    {
        return response()->json(Task::where('status',0)->latest()->get());
    }
    public function incomplate()
    {
        return response()->json(Task::where('status',1)->latest()->get());
    }


    public function create(Request $request)
    {
        if (Task::where('name' , $request->name)->first())
            return response()->json( ['status' => 'error' , 'error' =>'this task exist before']);
        else
            Task::create($request->all());

        return response()->json();

    }


    public function store(Request $request)
    {
        //
    }


    public function show(Task $task)
    {
        //
    }


    public function edit(Task $task)
    {
        //
    }


    public function update(Request $request)
    {
        $task = Task::find($request->id);
            if ($task->status == 1){
                $task->update([
                    'status'=>0,
                ]);
            }else
            {
                $task->update([
                    'status'=>1,
                ]);
            }


        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        Task::truncate();
    }
    public function deletetask(Request $request)
    {
        Task::find($request->id)->delete();
        return response()->json();

    }
}
