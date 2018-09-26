<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Report;
use App\Project;
use App\User;
use Session;
use DB;
use Auth;
use Validator;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reports($id)
    {
        $reports = Report::where('installer_id', $id)->get();
        $installers  = User::whereHas('roles', function($q){
                    $q->where('name', 'installer')
                    ->orWhere('name','employee');
                    })->get();

        $projects = Project::all();

        return view('workcenter.hrmanagement.reports', compact('reports', 'projects', 'installers'));
    }

    public function storeReport(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'installer_id' => 'required|integer',
            'scope_work' => 'required|min:5',
            'notes' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/projects/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $report = new Report();

            $report->project_id = $request->project_id;
            $report->leadInstaller = $request->leadInstaller;
            $report->installer_id = $request->installer_id;
            $report->scope_work = $request->scope_work;
            $report->notes = $request->notes;

            $report->save();

            Session::flash('success', 'Report Generated.');
            return redirect()->route('projects.show', $id);
        }
    }

    public function viewreport($id)
    {
        $report = Report::findOrfail($id);
        $projectId = Report::pluck('project_id', 'id')->get($id);
        $project = Project::where('id', $projectId)->first();
        $installerId = Report::pluck('installer_id', 'id')->get($id);
        $installer = User::where('id', $installerId)->first();

        return view('workcenter.hrmanagement.viewreport', compact('report', 'project', 'installer'));

    }

    public function editreport($id)
    {
        $report = Report::findOrfail($id);
        $installerId = Report::pluck('installer_id', 'id')->get($id);
        $installer = User::where('id', $installerId)->first();
        return view('workcenter.hrmanagement.editreport', compact('report', 'installer'));
    }

    public function updatereport(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'scope_work' => 'required|min:5',
            'notes' => 'required|min:15'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/hrmanagement/editreport/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $report = Report::findOrfail($id);

            $report->scope_work = $request->scope_work;
            $report->notes = $request->notes;

            $report->save();

            $installerId = Report::pluck('installer_id', 'id')->get($id);

            Session::flash('success', 'Report Updated.');
            return redirect()->route('hrmanagement.reports', $installerId);
        }
    }

    public function destroyReport($id)
    {
        $report = Report::findOrfail($id);
        $installerId = Report::pluck('installer_id', 'id')->get($id);
        $report->delete();

        Session::flash('success', 'Report Deleted');
        return redirect()->route('hrmanagement.reports', $installerId);
    }
}
