<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Carbon\Carbon;
use App\User;
use App\Project;
use App\Tasklist;
use Session;
use DB;
use App\PunchHour;
use Excel;
use Validator;

class AttendanceController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $attendances = DB::table('users') 
                ->join('punch_hours', 'users.id', '=', 'punch_hours.user_id')
                ->join('projects', 'punch_hours.project_id', '=', 'projects.id')
                ->select('users.*', 'projects.*', 'punch_hours.*')
                ->get();
        
        $projectHours = DB::table('projects')
                ->join('punch_hours', 'projects.id', '=', 'punch_hours.project_id')
                ->select(DB::raw('TIME_TO_SEC(TIMEDIFF(travelOut,travelIn)) as travel_hours,
                                    TIME_TO_SEC(TIMEDIFF(installOut, installIn)) as work_hours,
                                    projectName, user_id, punch_hours.project_id, punch_hours.id'))
                ->get();
      $projectHoursArray = $projectHours->toArray(); 
        // dd($projectHours);
        foreach ($projectHours as $projectHour)
        {
            $travelHrs = $projectHour->travel_hours;
            $installHrs = $projectHour->work_hours;

            $totalHrs = round(($travelHrs + $installHrs) / 3600, 2);
        }

        // dd($totalHrs);
        return view('workcenter.attendance.index', compact('attendances', 'projectHours', 'totalHrs'));
    }

    public function search()
    {
        return view('workcenter.attendance.search');
    }
    
    public function show($id)
    {
        $user = DB::table('users')
                ->join('punch_hours', 'users.id', '=', 'punch_hours.user_id')
                ->join('projects', 'punch_hours.project_id', '=', 'projects.id')
                ->select('users.*', 'projects.*', 'punch_hours.*')
                ->where('punch_hours.id', $id)           
                ->first();

                    $travelHoursIn = new Carbon($user->travelIn);
                    $travelHoursOut = new Carbon($user->travelOut);
                    $workIn = new Carbon($user->installIn);
                    $workOut = new Carbon($user->installOut);


                $travelHours = $travelHoursIn->diffInMinutes($travelHoursOut);
                $workHours = $workIn->diffInMinutes($workOut);

                $hours  = ($workHours + $travelHours);
                $hr = floor($hours/60) ? floor($hours/60). ' Hours' : '';
                $mt = $hours%60 ? $hours%60 .' minutes' : '';
                $totalhours = $hr && $mt ? $hr.' and '. $mt : $hr.$mt;

                $projectHours = DB::table('projects')
                            ->join('punch_hours', 'projects.id', '=', 'punch_hours.project_id')
                            ->select(DB::raw('TIMEDIFF(travelOut,travelIn) as travel_hours, 
                                                TIMEDIFF(installOut,installIn) as work_hours,
                                                projectName, user_id, punch_hours.project_id'))
                            ->where('punch_hours.id', $id)
                            ->get();
            
                $h = $projectHours->toArray();
                
        return view('workcenter.attendance.show')->withUser($user)->withProjectHours($h)->withTotalhours($totalhours);
    }

    public function totalHrs(Request $request, $id)
    {
        $start = $request->start;
        $end = $request->end;
        
        $query = DB::table('punch_hours')
                    ->select(DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(travelOut, travelIn))) as travel_hours,
                                    SUM(TIME_TO_SEC(TIMEDIFF(installOut, installIn))) as work_hours, users.firstName, users.lastName'))
                    ->join('users', 'punch_hours.user_id', '=', 'users.id')
                    ->whereBetween('travelIn', [$start, $end])
                    ->where('punch_hours.user_id', $id)
                    ->groupBy('users.firstName', 'users.lastName')
                    ->get();
        // dd($query);
        $time = $query->toArray();
        
        foreach ($time as $t)
        {
             $th = $t->travel_hours;
             $wh = $t->work_hours;

             $totalTime = $th + $wh;

             $officialTime = floor($totalTime / 3600) . gmdate(":i:s", $totalTime % 3600);
        }

        
         return view('workcenter.attendance.totalHrs', compact('totalTime', 'start', 'end', 'officialTime', 'query'));
    }

    public function edit($id)
    {
        $attendance = PunchHour::findOrFail($id);
        return view('workcenter.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'travelIn' => 'required|date',
            'travelOut' => 'required|date',
            'installIn' => 'required|date',
            'installOut' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/attendance/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $attendance = PunchHour::findOrFail($id);
            $attendance->travelIn = $request->travelIn;
            $attendance->travelOut = $request->travelOut;
            $attendance->installIn = $request->installIn;
            $attendance->installOut = $request->installOut;

            $attendance->save();

            Session::flash('success', 'Time sheet updated.');
            return redirect()->route('attendance.index');
        }
    }

    public function destroy($id)
    {
        $attendance = PunchHour::findOrFail($id);
        $attendance->delete();

        Session::flash('success', 'Deleted');
        return redirect()->route('attendance.index');
    }

    public function attendanceExport()
    {   

        $user_data = DB::table('users')
                ->join('punch_hours', 'users.id', '=', 'punch_hours.user_id')
                ->join('projects', 'punch_hours.project_id', '=', 'projects.id')
                ->select('users.*', 'projects.*', 'punch_hours.*')         
                ->get()
                ->toArray();
                $user_array[] = array('First Name', 'Last Name', 'Project Name', 'Travel In', 'Travel Out', 'Install In', 'Install Out');
                foreach($user_data as $user) {
                    $user_array[] = array(
                        'First Name' => $user->firstName,
                        'Last Name' => $user->lastName,
                        'Project Name' => $user->projectName,
                        'Travel In' => $user->travelIn,
                        'Travel Out' => $user->travelOut,
                        'Install In' => $user->installIn,
                        'Install Out' => $user->installOut,

                    );
                }
                Excel::create('Attendance Sheet', function($excel) use($user_array) {
                    $excel->sheet('Attendance Sheet', function($sheet) use($user_array) {
                        $sheet->fromArray($user_array);
                    });
                })->download('xlsx');

    }

    public function exportsearch(Request $request)
    {   

        $start = $request->start;
        $end = $request->end;
        $punchhours = DB::table('punch_hours')
                            ->select(DB::raw('TIME_TO_SEC(TIMEDIFF(travelOut, travelIn)) as travel_hours,
                                    TIME_TO_SEC(TIMEDIFF(installOut, installIn)) as work_hours, punch_hours.user_id, punch_hours.project_id, users.firstName, users.lastName, projects.projectName '))
                            ->join('users', 'punch_hours.user_id', '=', 'users.id')
                            ->join('projects', 'punch_hours.project_id', '=', 'projects.id')                        
                            ->whereBetween('travelIn', [$start, $end])
                            ->get()
                ->toArray();

                $user_array[] = array('First Name', 'Last Name', 'Project Name', 'From', 'To', 'Install Hours', 'Travel Hours', 'Total Hours');
                foreach($punchhours as $user) {
                    $user_array[] = array(
                        'First Name' => $user->firstName,
                        'Last Name' => $user->lastName,
                        'Project Name' => $user->projectName,
                        'From' => $start,
                        'To' => $end,
                        'Install Hours' => round(($user->work_hours/3600), 2),
                        'Travel Hours' => round(($user->travel_hours/3600), 2),
                        'Total Hours' => round(($user->work_hours + $user->travel_hours)/3600, 2),
                        // 'Install Out' => $user->installOut,

                    );
                }
                Excel::create('Attendance Sheet', function($excel) use($user_array) {
                    $excel->sheet('Attendance Sheet', function($sheet) use($user_array) {
                        $sheet->fromArray($user_array);
                    });
                })->download('xlsx');
    }

    public function singleexport(Request $request, $id)
    {   

        $start = $request->start;
        $end = $request->end;

        $query1 = User::where('id', $id)->get()->toArray();

        $query = DB::table('punch_hours')
                    ->select(DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(travelOut, travelIn))) as travel_hours,
                                    SUM(TIME_TO_SEC(TIMEDIFF(installOut, installIn))) as work_hours'))

                    ->whereBetween('travelIn', [$start, $end])
                    ->where('punch_hours.user_id', $id)
                    ->groupBy('punch_hours.user_id')
                    ->get()
                    ->toArray();
// dd($query);
                $user_array[] = array('First Name', 'Last Name', 'From', 'To', 'Total Hours');
                foreach($query as $user) {
                    foreach($query1 as $userdetails) {
                    $user_array[] = array(
                        'First Name' => $userdetails['firstName'],
                        'Last Name' => $userdetails['lastName'],
                        'From' => $start,
                        'To' => $end,
                        'Total Hours' => round(($user->work_hours + $user->travel_hours)/3600, 2),


                    );
                  }
                }
                Excel::create($userdetails['firstName'] .' '. $userdetails['lastName']. ' ' .'Time Sheet', function($excel) use($user_array) {
                    $excel->sheet('Attendance Sheet', function($sheet) use($user_array) {
                        $sheet->fromArray($user_array);
                    });
                })->download('xlsx');

    }


}
