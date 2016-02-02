<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{

    /**
     * Function for adding new user to database
     * @param Request $request [http request with data]
     * @return id [id of the task added]
     */
    public function add(Request $request)
    {


        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $task = new Task();
            $task->task_name = $request->task_name;
            $task->user_id = $user_id;
            $task->save();

            return $task->id;
        }


    }


    /**
     *Function for getting all tasks data and returning it to the view
     * @return view [returns home view with data of the tasks]
     */
    public function showTasks()
    {

        $username = '';
        $check = false;
        $active_count = 0;
        $completed_count = 0;
        $favorited_count = 0;
        $tasks = '';

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $username = Auth::user()->username;
            $check = true;
            $tasks = DB::table('tasks')->where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();

            if ($tasks) {

                $active_count = DB::table('tasks')->where('user_id', '=', $user_id)->where('completed', '=', 0)->count();
                $completed_count = DB::table('tasks')->where('user_id', '=', $user_id)->where('completed', '=', 1)->count();
                $favorited_count = DB::table('tasks')->where('user_id', '=', $user_id)->where('completed', '=', 1)->count();
            }


        } else {


            $check = false;
        }

        return view('pages.home')->with('check', $check)->with('username', $username)->with('tasks', $tasks)->with('active_count', $active_count)->with('completed_count', $completed_count)->with('favorited_count', $favorited_count);


    }


    /**
     * Function for updating task name with the new provided in the request
     * @param Request $request [http request with data]
     */
    public function updateTaskName(Request $request)
    {

        $id = 0;
        $new_name = '';

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $id = $request->base_id;
            $new_name = $request->new_name;
            DB::table('tasks')
                ->where('id', $id)
                ->where('user_id', $user_id)
                ->update(['task_name' => $new_name]);

        }

    }


    /**
     * Function for deleting all tasks from database
     */
    public function deleteAll()
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            DB::table('tasks')->where('user_id', $user_id)->delete();

        }


    }

    /**
     * Function for deleting all selected tasks from database
     */
    public function deleteSelected(Request $request)
    {

        if (Auth::check()) {
            $ids=$request->data;
            $user_id = Auth::user()->id;
            DB::table('tasks')->where('user_id', $user_id)->whereIn('id',$ids)->delete();

        }


    }


    /**
     * Function for updating completed value to 1(true)
     * @param Request $request [http request with data]
     */
    public function completeTask(Request $request)
    {

        $id = 0;


        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $id = $request->base_id;

            DB::table('tasks')
                ->where('id', $id)
                ->where('user_id', $user_id)
                ->update(['completed' => 1]);

        }


    }

    /**
     * Function for updating favorited value to 1(true)
     * @param Request $request [http request with data]
     */
    public function favoriteTask(Request $request)
    {

        $id = 0;


        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $id = $request->base_id;

            DB::table('tasks')
                ->where('user_id', $user_id)
                ->update(['favorited' => 1]);

        }


    }

    /**
     * Function for deleting task by provided id
     * @param Request $request [http request with data]
     */
    public function deleteTask(Request $request)
    {


        $id = 0;

        if (Auth::check()) {
            $id = $request->base_id;

            $user_id = Auth::user()->id;
            DB::table('tasks')
                ->where('user_id', $user_id)
                ->where('id', $id)
                ->delete();


        }


    }


}
