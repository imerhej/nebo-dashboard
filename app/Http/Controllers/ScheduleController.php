<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Schedule;
use App\Inventory;
use Auth;
use DB;
use Session;
use Calendar;
use Event;
use Validator;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function schedule()
    {
        $users = User::whereHas('roles', function($q){
            $q->where('name','installer');
            })->get();
        
        $projects = Project::where('active', 1)->get();
        $inventories = Inventory::all();

        $schedules = DB::table('users')
                    ->join('schedules', 'users.id', '=', 'schedules.installer_id')
                    ->join('projects', 'schedules.project_id', '=', 'projects.id')
                    ->select('users.*', 'projects.*', 'schedules.*')
                    ->get()
                    ->toArray();
  
        $flagCounts = DB::table('schedules')
                    ->join('users', 'schedules.installer_id', '=', 'users.id')
                    ->select('users.firstName', 'users.lastName')
                    ->select(DB::raw('installer_id, users.firstName, users.lastName, count(flag) as flg'))
                    ->groupBy('flag', 'installer_id', 'users.firstName', 'users.lastName')
                    ->having('flg', '>', 1)
                    ->get()
                    ->toArray();
     
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
        $schedule_details = Calendar::addEvents($schedule_list);
        return view('workcenter.schedule.index', compact('users', 'projects', 'schedules', 'schedule_details', 'flagCounts', 'inventories'));
    }

    public function storeSchedule (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/schedule/index')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $installers = count($request->installer_id);         

            for ($i = 0; $i <= $installers; $i++) {
                foreach ($request->installer_id as $installer_id) {
                    $schedule = new Schedule();
                    
                    $schedule->project_id = $request->project_id;
                    $schedule->installer_id = $installer_id;
                    $schedule->equipment_name = implode(", ",$request->equipment_name);
                    $schedule->start_date = $request->start_date;
                    $schedule->end_date = $request->end_date;
                    $schedule->flag = 1;

                    $schedule->save();
                    $count = DB::table('schedules')
                            ->select(DB::raw('count(*) as flg, flag'))
                            ->where('installer_id', '=', $installer_id)
                            ->groupBy('flag')
                            ->get()
                            ->toArray();

                }

                    if ($count[0]->flg == 1) {
        
                        Session::flash('success', 'Saved!');
                        return redirect()->route('schedule.index');
                    } else if ($count[0]->flg > 1) {
        
                        Session::flash('warning', 'Saved! double booking');
                        return redirect()->route('schedule.index');
                        
                    }    
                
            }

        }
    }


    public function destorySchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        // dd($schedule);
        $schedule->delete();

        Session::flash('success', 'Deleted!');
        // return redirect()->route('schedule.index');
        return redirect('workcenter/schedule/index');


    }
}
