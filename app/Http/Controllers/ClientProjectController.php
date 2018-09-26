<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Calendar;
use Event;
use Carbon\Carbon;
use App\Role;
use App\Project;
use App\TaskFile;
use App\ChangeOrder;
use App\ProjectDetail;
use DB;
use Session;
use Hash;
use Validator;

class ClientProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listMyProjects($id)
    {
        $client = User::findOrFail($id);
        $projects = DB::table('projects')
                ->join('client_project', 'projects.id', '=', 'client_project.project_id')
                ->join('users','client_project.client_id', '=', 'users.id')
                ->join('project_details', 'projects.id', '=', 'project_details.project_id')
                ->where('client_id', $id)
                ->get();
                // dd($projects);

        return view('workcenter.clients.myproject', compact('client','projects'));
        
    }

    public function getMyProject($id)
    {
        // $client = User::findOrFail($id);
        $project = Project::where('id', $id)->get();
        $projectdetail = ProjectDetail::where('project_id', $id)->get();

        $client = DB::table('users')
                    ->join('client_project', 'users.id', '=', 'client_project.client_id')
                    ->where('project_id', $id)
                    ->first();

        $supervisor = DB::table('users')
                    ->join('project_user', 'users.id', '=', 'project_user.user_id')
                    ->where('project_id', $id)
                    ->get();
            //   dd($supervisor);
        foreach($supervisor as $super){}
          
        $userAddress = DB::table('addresses')
                ->join('users', 'addresses.user_id', '=', 'users.id')
                // ->select('addresses.*')
                ->where('user_id', $super->id)
                ->get();
                foreach($userAddress as $userdetails){}    
                // dd($userdetails);
        $changeOrders = ChangeOrder::where('project_id', $id)->get();
        // dd($changeOrders);
            //    dd($project);
        $project_list = [];

        foreach ($project as $myproject) {
            $project_list[] = Calendar::event(
                $myproject->projectName,
                true,
                new \DateTime($myproject->start_date),
                new \DateTime($myproject->end_date.' +1 day'),
                $myproject->id,
                [
                  'url' => 'http://www.excelomega.com/neboexpress/workcenter/clients/myproject/'.$myproject->id,
                  'color' => $myproject->color
                ]
            );
        
        }            
        $files = TaskFile::where('project_id', $id)->get();      
                  
        $projectdetails = Calendar::addEvents($project_list);
        return view('workcenter.clients.viewmyproject', compact('client','projectdetails', 'projectdetail','files', 'myproject', 'super', 'userdetails', 'changeOrders'));
    }

    public function viewChangeOrder($id)
    {
        $changeOrder = ChangeOrder::findOrFail($id);
        // dd($changeOrder);
        return view('workcenter.clients.viewChangeOrder', compact('changeOrder'));

    }

    public function updateChangeOrder(Request $request, $id)
    {
        $current = Carbon::now();

        $validator = Validator::make($request->all(),[
            'client_signature' => 'required|min:5'
        ]);
        if ($validator->fails()) {
            return redirect('workcenter/clients/viewChangeOrder/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $changeOrder = ChangeOrder::firstOrNew(array('id' => $id));
            // $changeOrder->project_id = $request->project_id;
            // $changeOrder->client_id = $request->client_id;
            // $changeOrder->user_id = $request->user_id;
            $changeOrder->client_signature = $request->client_signature;
            $changeOrder->client_signature_date = $current;
            // dd($changeOrder);
            $changeOrder->save();
            
            $client_id = ChangeOrder::pluck('client_id', 'id')->get($id);

            Session::flash('success', 'Signature Accepted, Thank you!');
            return redirect()->route('clients.myproject', $client_id);
        }
    }
}
