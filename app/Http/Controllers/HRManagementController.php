<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Department;
use App\Project;
use App\Tasklist;
use App\Performance;
use Session;
use DB;
use Validator;

class HRManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $users = User::all();
        $departments = Department::all();
        $projects = Project::all();
        return view('workcenter.hrmanagement.index', compact('users', 'departments', 'projects'));
    }

    public function getDepartments()
    {   
        $departments = Department::all();
        $users = User::all();
        return view('workcenter.hrmanagement.departments', compact('departments', 'users'));
    }

    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'departmentTitle' => 'required|min:3|max:100',
            'description' => 'sometimes',
            'departmentLead' => 'sometimes'
        ]);

        $department = new Department();
        $department->departmentTitle = $request->departmentTitle;
        $department->description = $request->description;
        $department->departmentLead = $request->departmentLead;

        $department->save();

        Session::flash('success', 'Department Created Successfully');
        return redirect()->route('hrmanagement.departments');
    }

    public function editDepartment($id) 
    {
        $department = Department::findOrFail($id);
        $users = User::all();
        return view('workcenter.hrmanagement.editDepartment', compact('department', 'users'));
    }

    public function updateDepartment (Request $request, $id)
    {
        $this->validate($request, [
            'departmentTitle' => 'required|min:3|max:100',
            'description' => 'sometimes',
            'departmentLead' => 'sometimes'
        ]);

        $department = Department::findOrFail($id);

        $department->departmentTitle = $request->departmentTitle;
        $department->description = $request->description;
        $department->departmentLead = $request->departmentLead;
            // dd($department);
        $department->save();

        Session::flash('success', 'Department Updated Successfully');
        return redirect()->route('hrmanagement.departments');
    }

    public function destroyDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        Session::flash('success', 'Department Deleted!');
        return redirect()->route('hrmanagement.departments');
        
    }
    
    public function getAvailability()
    {
        // $users = User::all();
        $users = User::whereHas('roles', function($q){
            $q->where('name', 'superadministrator')
              ->orWhere('name','administrator')
              ->orWhere('name', 'office-manager')
              ->orWhere('name','manager')
              ->orWhere('name','supervisor')
              ->orWhere('name','installer')
              ->orWhere('name','employee');
            })->get();
        $tasklists = Tasklist::all();
        $projects = Project::all();

        // $busyUser = $tasklist->users()->wherePivot('tasklist_id' , $id)->pluck('id')->toArray();
        // dd($busyUser);
        return view('workcenter.hrmanagement.availability', compact('users', 'tasklists', 'projects'));
    }


    public function getEmployees() 
    {
        $employees = User::whereHas('roles', function($q){
                    $q->where('name', 'superadministrator')
                    ->orWhere('name','administrator')
                    ->orWhere('name', 'office-manager')
                    ->orWhere('name','manager')
                    ->orWhere('name','supervisor')
                    ->orWhere('name','installer')
                    ->orWhere('name','employee');
                    })->get();

        $performances = DB::table('users')
                ->join('performances', 'users.id', '=', 'performances.user_id')
                ->select('performances.*')
                ->get();
        
        // $count = Performance::where('user_id', 45)->count();
        // dd($count);
        foreach($performances as $performance) {
            $a = $performance->job_knowledge;
            $b = $performance->work_quality;
            $c = $performance->attendance_punctuality;
            $d = $performance->initiative;
            $e = $performance->comm_listening;
            $f = $performance->dependability;

            $average = ((($a + $b + $c + $d + $e + $f) / 30) * 100);
        }
                

        return view('workcenter.hrmanagement.employees', compact('employees', 'average', 'performances'));
    }

    public function performance($id)
    {
        $employee = User::findOrFail($id);
        $performances = Performance::where('user_id', $id)->get();
        return view('workcenter.hrmanagement.performance', compact('employee', 'performances'));
    }

    public function createperformance($id)
    {   
        $employee = User::findOrFail($id);
        return view('workcenter.hrmanagement.createperformance', compact('employee'));
    }

    public function storeperformance(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'jobTitle' => 'required',
            'review_date' => 'required',
            'department' => 'required',
            'manager' => 'required',
            'review_period' => 'sometimes',
            'job_knowledge' => 'required|integer',
            'work_quality' => 'required|integer',
            'attendance_punctuality' => 'required|integer',
            'initiative' => 'required|integer',
            'comm_listening' => 'required|integer',
            'dependability' => 'required|integer',
            'rating_comments' => 'sometimes',
            'additional_comments' => 'sometimes',
            'goals' => 'sometimes',
            'employee_signature' => 'sometimes',
            'employee_date' => 'sometimes',
            'manager_signature' => 'sometimes',
            'manager_date' => 'sometimes',
       ]);

       if ($validator->fails()) {
        return redirect('workcenter/hrmanagement/createperformance/'.$id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

        $performance = new Performance();
        $performance->user_id = $request->user_id;
        $performance->name = $request->name;
        $performance->jobTitle = $request->jobTitle;
        $performance->review_date = $request->review_date;
        $performance->department = $request->department;
        $performance->manager = $request->manager;
        $performance->review_period = $request->review_period;
        $performance->job_knowledge = $request->job_knowledge;
        $performance->work_quality = $request->work_quality;
        $performance->attendance_punctuality = $request->attendance_punctuality;
        $performance->initiative = $request->initiative;
        $performance->comm_listening = $request->comm_listening;
        $performance->dependability = $request->dependability;
        $performance->rating_comments = $request->rating_comments;
        $performance->additional_comments = $request->additional_comments;
        $performance->goals = $request->goals;
        $performance->employee_signature = $request->employee_signature;
        $performance->employee_date = $request->employee_date;
        $performance->manager_signature = $request->manager_signature;
        $performance->manager_date = $request->manager_date;

        $performance->save();
        
        Session::flash('success', 'Performance review saved.');
        return redirect()->route('hrmanagement.performance', $id);

        }
    }

    public function viewperformance($id)
    {
        $performance = Performance::findOrFail($id);
        $a = $performance->job_knowledge;
        $b = $performance->work_quality;
        $c = $performance->attendance_punctuality;
        $d = $performance->initiative;
        $e = $performance->comm_listening;
        $f = $performance->dependability;

        $average = ((($a + $b + $c + $d + $e + $f) / 30) * 100);
        
        return view('workcenter.hrmanagement.viewperformance', compact('performance', 'average'));
    }

    public function editperformance($id)
    {
        $performance = Performance::findOrFail($id);
        return view('workcenter.hrmanagement.editperformance', compact('performance'));
    }

    public function updateperformance(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'jobTitle' => 'required',
            'review_date' => 'required',
            'department' => 'required',
            'manager' => 'required',
            'review_period' => 'sometimes',
            'job_knowledge' => 'required|integer',
            'work_quality' => 'required|integer',
            'attendance_punctuality' => 'required|integer',
            'initiative' => 'required|integer',
            'comm_listening' => 'required|integer',
            'dependability' => 'required|integer',
            'rating_comments' => 'sometimes',
            'additional_comments' => 'sometimes',
            'goals' => 'sometimes',
            'employee_signature' => 'sometimes',
            'employee_date' => 'sometimes',
            'manager_signature' => 'sometimes',
            'manager_date' => 'sometimes',
       ]);

       if ($validator->fails()) {
        return redirect('workcenter/hrmanagement/createperformance/'.$id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

        $performance = Performance::findOrFail($id);

        $performance->user_id = $request->user_id;
        $performance->name = $request->name;
        $performance->jobTitle = $request->jobTitle;
        $performance->review_date = $request->review_date;
        $performance->department = $request->department;
        $performance->manager = $request->manager;
        $performance->review_period = $request->review_period;
        $performance->job_knowledge = $request->job_knowledge;
        $performance->work_quality = $request->work_quality;
        $performance->attendance_punctuality = $request->attendance_punctuality;
        $performance->initiative = $request->initiative;
        $performance->comm_listening = $request->comm_listening;
        $performance->dependability = $request->dependability;
        $performance->rating_comments = $request->rating_comments;
        $performance->additional_comments = $request->additional_comments;
        $performance->goals = $request->goals;
        $performance->employee_signature = $request->employee_signature;
        $performance->employee_date = $request->employee_date;
        $performance->manager_signature = $request->manager_signature;
        $performance->manager_date = $request->manager_date;
            // dd($performance);
        $performance->save();
        
        Session::flash('success', 'Performance review updated.');
        return redirect()->route('hrmanagement.viewperformance', $id);

        }

    }

    public function destroyperformance($id)
    {
        $performance = Performance::findOrFail($id);
        $userId = Performance::pluck('user_id', 'id')->get($id);
        $performance->delete();

        Session::flash('success', 'Performance Review deleted.');
        return redirect()->route('hrmanagement.performance', $userId);
    }


}
