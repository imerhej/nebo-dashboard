<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Calendar;
use App\Task;
use App\Leave;
use App\User;
use Event;
use DB;

class CalendarController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    //   $tasks = Task::all();
      $projects = Project::all();
    //   $task_list = [];
      $project_list = [];

        foreach ($projects as $key => $project) {
          $project_list[] = Calendar::event(
                  $project->projectName,
                  true,
                  new \DateTime($project->start_date),
                  new \DateTime($project->end_date.' +1 day'),
                  $project->id,
                  [
                    'url' => 'http://www.excelomega.com/neboexpress/workcenter/projects/'.$project->id,
                    'color' => $project->color
                  ]
              );
            }
            // dd($project_list);
    //     foreach ($tasks as $key => $task) {
    //     $task_list[] = Calendar::event(
    //             $task->name,
    //             true,
    //             new \DateTime($task->start_date),
    //             new \DateTime($task->end_date.' +1 day'),
    //             $task->id,
    //             [
    //               'url' => 'http://www.excelomega.com/neboexpress/tasks/'.$task->id,
    //               'color' => $task->color
    //             ]
    //         );
            
    //   }
// dd($project_list);
      // $eloquentEvent = Event::all();
      // dd($eloquentEvent);
    //   $task_details = Calendar::addEvents($task_list);
      $project_details = Calendar::addEvents($project_list);
      // dd($calendar_details);

      return view('workcenter.calendar.index', compact('project_details') );
    }

    public function rtoCalendar()
    { 
         $leaves = Leave::where('status','=', 'approved')->get();
         $pending = Leave::where('status', '=', 'pending')->get();
         $denied = Leave::where('status', '=', 'denied')->get();
         $rto_list = [];
         
        foreach ($leaves as $key => $leave) {
              $rto_list[] = Calendar::event(
              $leave->fullName,
              true,
              new \DateTime($leave->start_date),
              new \DateTime($leave->end_date.' +1 day'),
              $leave->id,
              [
                'url' => 'http://www.excelomega.com/neboexpress/workcenter/rto/'.$leave->id .'/edit',
                'color' => $leave->color
              ]
          );
        }
           
            
      $rto_details = Calendar::addEvents($rto_list);
  

      return view('workcenter.rto.calendar', compact('rto_details', 'pending', 'denied', 'leaves') );
    }
}
