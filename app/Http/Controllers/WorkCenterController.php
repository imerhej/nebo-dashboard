<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Tasklist;
use App\Color;
use App\ProjectRate;
use App\ProjectBudget;
use App\PunchHour;
use App\Schedule;
use Calendar;
use Event;
use DB;
use Carbon\Carbon;

class WorkCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      return redirect()->route('workcenter.workcenter');
    }

    public function workcenter()
    {
      $projects = Project::all();

      $tasklists = Tasklist::all();
      $users = User::all();
      $projectbudgets = ProjectBudget::all();
      $punchhours = PunchHour::all();
      
      $schedules = DB::table('users')
                    ->join('schedules', 'users.id', '=', 'schedules.installer_id')
                    ->join('projects', 'schedules.project_id', '=', 'projects.id')
                    ->select('users.*', 'projects.*', 'schedules.*')
                    ->get();

        $schedule_list = [];

        foreach($schedules as $key => $schedule) {
                $schedule_list[] = Calendar::event(
                    $schedule->firstName,
                    true,
                    new \DateTime($schedule->start_date),
                    new \DateTime($schedule->end_date.' +1 day'),
                    $schedule->project_id,
                    [
                        'url' => 'http://www.excelomega.com/neboexpress/workcenter/projects/'.$schedule->project_id,
                        'color' => '#b9d539'
                    ]
                );
        }
      $scheduledetails = Calendar::addEvents($schedule_list);

      $projecthrs = DB::table('projects')
                        ->join('punch_hours', 'projects.id', '=', 'punch_hours.project_id')
                        ->select(DB::raw('TIMEDIFF(travelOut,travelIn) as travel_hours, 
                                          TIMEDIFF(installOut,installIn) as work_hours,
                                          projectName, project_id'))
                        ->get();

                        foreach ($punchhours as $hour){ 

            
                              $travelHoursIn = new Carbon($hour->travelIn);
                              $travelHoursOut = new Carbon($hour->travelOut);
                              $workIn = new Carbon($hour->installIn);
                              $workOut = new Carbon($hour->installOut);
                              
                              $travelHours = $travelHoursIn->diffInMinutes($travelHoursOut);
                              $workHours = $workIn->diffInMinutes($workOut);
                  
                              $thours  = $workHours + $travelHours;
                              $hr = floor($thours/60) ? floor($thours/60). ' Hours' : '';
                              $mt = $thours%60 ? $thours%60 .' minutes' : '';
                              $totalhours = $hr && $mt ? $hr.' and '. $mt : $hr.$mt;
                              
                          }
                  
                      //  dd($totalhours);
      // budgets is used for google charts
      $budgets = DB::table('projects')
                        ->join('project_budgets', 'projects.id', '=', 'project_budgets.project_id')
                        ->select('project_budgets.*', 'projects.*')
                        ->where('active', 1)
                        ->get();
      // dd($projecthrs);
      $activeTasks = DB::table('tasklists')
                ->select(DB::raw('count(*) as activetasks, active'))
                ->where('active', '=', 1)
                ->groupBy('active')
                ->get();
      $completeTasks = DB::table('tasklists')
                ->select(DB::raw('count(*) as completetasks, active'))
                ->where('active', '=', 0)
                ->groupBy('active')
                ->get();
      return view('workcenter.workcenter')
              ->withProjects($projects)
              ->withTasklists($tasklists)
              ->withActiveTasks($activeTasks)
              ->withCompleteTasks($completeTasks)
              ->withUsers($users)
              ->withScheduledetails($scheduledetails)
              ->withBudgets($budgets)
              ->withPunchhours($punchhours)
            //   ->withTotalhours($totalhours)
              ->withProjectbudgets($projectbudgets);
    }
    
}
