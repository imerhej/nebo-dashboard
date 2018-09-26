<?php

namespace App\Http\Controllers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Notifications\TaskPosted;
use Carbon\Carbon;
use Notification;
use Purifier;
use App\Client;
use App\Color;
use App\Project;
use App\Category;
use App\Tasklist;
use App\Milestone;
use App\Department;
use App\Discussion;
use App\ProjectDetail;
use App\ProjectRate;
use App\ProjectBudget;
use App\PunchHour;
use App\File;
use App\TaskFile;
use App\User;
use App\Role;
use App\State;
use App\Checklist;
use App\Inventory;
use App\InventoryProject;
use App\Rate;
use App\TCO;
use Auth;
use Session;
use DB;
use Calendar;
use Event;
use Mail;
use Validator;

class ProjectController extends Controller
{   
 
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->has('active')) {
            $projects = Project::where('active', request('active'))->get();
            $categories = Category::all();
            $tasklists = Tasklist::all();
            $users = User::all();
            $departments = Department::all();
            $files = File::all();
            $posts = Discussion::all();
            $userPermission = Auth::user()->hasPermission('read-project');         
            $activeCounts = DB::table('projects')
                    ->select(DB::raw('count(*) as activeProjects, active'))
                    ->where('active', '=', 1)
                    ->groupBy('active')
                    ->get();
                    
            $completedCounts = DB::table('projects')
                    ->select(DB::raw('count(*) as completedProjects, active'))
                    ->where('active', '=', 0)
                    ->groupBy('active')
                    ->get();
            return view('workcenter.projects.index')
                ->withProjects($projects)
                ->withCategories($categories)
                ->withTasklists($tasklists)
                ->withUsers($users)
                ->withDepartments($departments)
                ->withFiles($files)
                ->withPosts($posts)
                ->withActiveCounts($activeCounts)
                ->withCompletedCounts($completedCounts)
                ->withUserPermission($userPermission);
        } else if (request()->has('completed')){
            $projects = Project::where('completed', request('completed'))->get();
            $categories = Category::all();
            $tasklists = Tasklist::all();
            $users = User::all();
            $departments = Department::all();
            $files = File::all();
            $posts = Discussion::all();
            $userPermission = Auth::user()->hasPermission('read-project');
            $activeCounts = DB::table('projects')
                    ->select(DB::raw('count(*) as activeProjects, active'))
                    ->where('active', '=', 1)
                    ->groupBy('active')
                    ->get();
            $completedCounts = DB::table('projects')
                    ->select(DB::raw('count(*) as completedProjects, active'))
                    ->where('active', '=', 0)
                    ->groupBy('active')
                    ->get();
            return view('workcenter.projects.index')
                ->withProjects($projects)
                ->withCategories($categories)
                ->withTasklists($tasklists)
                ->withUsers($users)
                ->withDepartments($departments)
                ->withFiles($files)
                ->withPosts($posts)
                ->withActiveCounts($activeCounts)
                ->withCompletedCounts($completedCounts)
                ->withUserPermission($userPermission);
        }  else {
            $projects = Project::orderBy('id', 'desc')->get();
            $categories = Category::all();
            $tasklists = Tasklist::all();
            $milestones = Milestone::all();
            $users = User::all();
            $departments = Department::all();
            $id = Auth::user();
            $userdetails = DB::table('project_user')
                ->join('projects', 'project_user.project_id', '=', 'projects.id')
                ->select('project_user.user_id')
                ->where('user_id', Auth::user())
                ->get();
            // dd($userdetails);
            $files = File::all();
            $posts = Discussion::all();
            $userPermission = Auth::user()->hasPermission('read-project');
            $activeCounts = DB::table('projects')
                    ->select(DB::raw('count(*) as activeProjects, active'))
                    ->where('active', '=', 1)
                    ->groupBy('active')
                    ->get();
            $completedCounts = DB::table('projects')
                    ->select(DB::raw('count(*) as completedProjects, active'))
                    ->where('active', '=', 0)
                    ->groupBy('active')
                    ->get();
            
            return view('workcenter.projects.index')
                ->withProjects($projects)
                ->withCategories($categories)
                ->withTasklists($tasklists)
                ->withMilestones($milestones)
                ->withUsers($users)
                ->withDepartments($departments)
                ->withFiles($files)
                ->withPosts($posts)
                ->withActiveCounts($activeCounts)
                ->withCompletedCounts($completedCounts)
                ->withUserPermission($userPermission);
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        // $projects = Project::all();
        $colors = Color::all();
        // $users = User::all();
        $clients = Role::where('name','client')->first()->users()->get();
        // $users = User::whereHas('roles', function($q){
        //     $q->where('name','supervisor');
        //     })->get();
        $users = User::whereHas('roles', function($q){
            $q->where('name', 'superadministrator')
              ->orWhere('name','administrator')
              ->orWhere('name', 'office-manager')
              ->orWhere('name','manager')
              ->orWhere('name','supervisor')
              ->orWhere('name','installer')
              ->orWhere('name','employee');
            })->get();
       
        $states = State::all();
        $departments = Department::all();
        return view('workcenter.projects.create')
                ->withCategories($categories)
                ->withUsers($users)
                ->withStates($states)
                ->withDepartments($departments)
                ->withClients($clients)
                ->withColors($colors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request);
        $validator = Validator::make($request->all(), [
            'pid' => 'sometimes',
            'projectNumber' => 'sometimes',
            'quoteNumber' => 'sometimes',
            'orderNumber' => 'sometimes',
            'projectName' => 'sometimes',
            'description' => 'sometimes',
            'categoryName' => 'sometimes',
            'departmentTitle' => 'sometimes',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'color' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/projects/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

        $project = new Project();
        $project->pid = $request->pid;
        $project->projectNumber = $request->projectNumber;
        $project->quoteNumber = $request->quoteNumber;
        $project->orderNumber = $request->orderNumber;
        $project->projectName = $request->projectName;
        $project->description = $request->description;
        $project->categoryName = $request->categoryName;
        $project->departmentTitle = $request->departmentTitle;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->color = $request->color;

        
        $userID = $request->users;
        // $collection = collect($userID);

        foreach ($userID as $id){

            $user = User::where('id', $id)->first();
        }
        // $user = User::
        // dd($userID[0]);
        // $user = User::findOrFail($userID); 
         // Send email to supervisor when project createds
         $data = array(
            'sender' => Auth::user()->email,
            'firstName' => Auth::user()->firstName,
            'lastName' => Auth::user()->lastName,
            'email' => Auth::user()->email,
            'supervisorEmail' => $user->email,
            'supervisorFname' => $user->firstName,
            'supervisorLname' => $user->lastName,
            'projectName' => $request->projectName,
            'projectDetails' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
            );
    // dd($data);
        Mail::send('workcenter.emails.projectCreated', $data, function($message) use($data) {
            $message->from($data['sender']);
            $message->to($data['supervisorEmail']);
            $message->subject('Project Created');
        });
            // dd($project);
        $project->save();
        $project->clients()->sync($request->client_id, false);
        $project->users()->sync($request->users, false);
        // $project->user()->sync($request->user, false);
        // $project->category()->sync($request->category_id, false);
        // $project->department()->sync($request->department_id, false);
 
    
        if ($project->save())
        {
            $project_id = $project->id;
            $project_details = [
                'project_id' => $project_id,
                'clientName' => $request->clientName,
                'phone_number' => $request->phone_number,
                'productionTime' => $request->productionTime,
                'projectDirections' => $request->projectDirections,
                'invoiceTo' => $request->invoiceTo,
                'numberPersonnel' => $request->numberPersonnel,
                'projectedHrs' => $request->projectedHrs,
                'quotedDated' => $request->quotedDated,
                'quotedBy' => $request->quotedBy,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode];

            $project_detail = ProjectDetail::where('project_id', $project_id)->insert($project_details);
        }

        Session::flash('success', 'Project Created Successfully!');
        return redirect()->route('projects.index');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $current = Carbon::now();
        $project = Project::findOrFail($id);
        $rates = Rate::all();
        $userPermission = Auth::user()->hasPermission('read-project');
        // dd($userPermission);
        $userRole = Auth::user()->hasRole(['superadministrator']);
        $tcos = TCO::where('project_id', $id)->get();
        $installers  = User::whereHas('roles', function($q){
                    $q->where('name', 'installer')
                    ->orWhere('name','employee');
                    })->get();
        
        $daysleft = DB::table('projects')
                    ->select(DB::raw('DATEDIFF(end_date, NOW()) as days'))
                    ->where('id', $id)
                    ->get();
        
        foreach($daysleft as $leftdays)

        $projectLeftDays = $leftdays->days;

        // if ($projectLeftDays < 0 || $projectLeftDays == 0) {

        //     $daysCount = $projectLeftDays + 1;

        // } elseif ($projectLeftDays > 0) {

        //     $daysCount = $projectLeftDays;
        // }
        // dd($daysCount);
        $days = DB::table('projects')
                    ->select(DB::raw('DATEDIFF(end_date, start_date) as days'))
                    ->where('id', $id)
                    ->get();

        foreach($days as $count)
        $totalProjectDays = $count->days;

        // if ($totalProjectDays < 0 || $totalProjectDays == 0 ) {

        //     $totalDays = $totalProjectDays + 1;

        // } else if($totalProjectDays > 0) {

        //     $totalDays = $totalProjectDays;
        // }
        // dd($totalDays);
        $percent = ($projectLeftDays * 100) / $totalProjectDays;
    
        $percentUsed =  (100 - $percent);  

       
        // $clientproject = DB::table('client_project')
        //         ->select(DB::raw('client_project.client_id'))
        //         ->where('project_id', $id)
        //         ->first();

        $client = DB::table('users')
                    ->join('client_project', 'users.id', '=', 'client_project.client_id')
                    ->where('client_project.project_id', $id)
                    ->get();
            //  dd($client);   
        // if (empty($clientproject->client_id)) {
        //     dd($clientproject);
        // }
        
        // $clientID = $clientproject->client_id;
        // $client = User::where('id', $clientID)->first();

        $tasklist = Tasklist::where('project_id', $id)->get();
        
        $milestones = Milestone::where('project_id', $id)->get();
        $milestoneArray = $milestones->toArray();
        $tasklistArray = $tasklist->toArray();
        $completed = DB::table('tasklists')
                        ->select(DB::raw('count(*) as completedTasks, active'))
                        ->where('active', '=', 0)
                        ->where('project_id', '=', $id)
                        ->groupBy('active')
                        ->get();

        $active = DB::table('tasklists')
                    ->select(DB::raw('count(*) as activeTasks, active'))
                    ->where('active', '=', 1)
                    ->where('project_id', '=', $id)
                    ->groupBy('active')
                    ->get();
        // dd($active);
        $project_details = [];
        $milestone_details = [];
        $tasklist_details = [];

        $project_details[] = Calendar::event(
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


        // foreach ($milestoneArray as $milestone) {
        //     $milestone_details[] = Calendar::event(
        //         $milestone['milestoneName'],
        //         true,
        //         new \DateTime($milestone['start_date']),
        //         new \DateTime($milestone['end_date'].' +1 day'),
        //         $milestone['id'],
        //         [
        //             'url' => 'http://www.excelomega.com/neboexpress/workcenter/projects/milestones/'.$project->id,
        //             'color' => $milestone['color']
        //         ]
        //     );
        // }

        foreach ($tasklistArray as $tasklist) {
            $tasklist_details[] = Calendar::event(
                $tasklist['tasklistname'],
                true,
                new \DateTime($tasklist['start_date']),
                new \DateTime($tasklist['end_date'].' +1 day'),
                $tasklist['id'],
                [
                    'url' => 'http://www.excelomega.com/neboexpress/workcenter/projects/tasklists/'.$project->id,
                    'color' => $tasklist['color']
                ]
            );
        }
           
        $projectEvent = Calendar::addEvents($project_details);
        // $milestoneEvent = Calendar::addEvents($milestone_details);
        $tasklistEvent = Calendar::addEvents($tasklist_details);

        $categories = Category::pluck('categoryName', 'categoryName');
        return view('workcenter.projects.show')
                ->withProject($project)
                ->withCategories($categories)
                ->withCompleted($completed)
                ->withActive($active)
                ->withRates($rates)
                ->withClient($client)
                ->withTcos($tcos)
                ->withPercentUsed($percentUsed)
                ->withPercent($percent)
                ->withTotalProjectDays($totalProjectDays)
                ->withProjectLeftDays($projectLeftDays)
                ->withInstallers($installers)
                ->withProjectEvent($projectEvent)
                ->withUserPermission($userPermission)
                ->withUserRole($userRole)
                ->withTasklistEvent($tasklistEvent);
                
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $departments = Department::all();
        $categories = Category::all();
        $colors = Color::all();
        $states = State::all();
        $clients = Role::where('name','client')->first()->users()->get();
        $projectDetails = $project->projectDetail;

        // $clientId = DB::table('client_project')
        //         ->select('client_project.client_id')
        //         ->where('client_project.project_id', $id)
        //         ->first();
        $projectclient = DB::table('users')
                    ->join('client_project', 'users.id', '=', 'client_project.client_id')
                    ->where('client_project.project_id', $id)
                    ->first();
            // dd($projectclient);
        $users = User::whereHas('roles', function($q){
            $q->where('name', 'superadministrator')
              ->orWhere('name','administrator')
              ->orWhere('name', 'office-manager')
              ->orWhere('name','manager')
              ->orWhere('name','supervisor')
              ->orWhere('name','installer')
              ->orWhere('name','employee');
            })->get();
        
        $users2 = array();
        foreach ($users as $user) {
            $users2[$user->id] = $user->firstName;
        }

        $userProject = DB::table('users')
                    ->join('project_user', 'users.id', '=', 'project_user.user_id')
                    ->where('project_user.project_id', $id)
                    ->first();

        return view('workcenter.projects.edit')
                ->withProject($project)
                ->withDepartments($departments)
                ->withCategories($categories)
                ->withUsers($users2)
                 ->withColors($colors)
                ->withClients($clients)
                ->withProjectclient($projectclient)
                // ->withClientId($clientId)
                ->withUserProject($userProject)
                ->withStates($states)
                ->withProjectDetails($projectDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'sometimes',
            'projectNumber' => 'sometimes',
            'quoteNumber' => 'sometimes',
            'orderNumber' => 'sometimes',
            'projectName' => 'sometimes',
            'description' => 'sometimes',
            'categoryName' => 'sometimes',
            'departmentTitle' => 'sometimes',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'color' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect('workcenter/projects/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        } else {

        $project = Project::findOrFail($id);

        $project->pid = $request->pid;
        $project->projectNumber = $request->projectNumber;
        $project->quoteNumber = $request->quoteNumber;
        $project->orderNumber = $request->orderNumber;
        $project->projectName = $request->projectName;
        $project->description = $request->description;
        $project->categoryName = $request->categoryName;
        $project->departmentTitle = $request->departmentTitle;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->color = $request->color;
        $project->active = $request->active;

        $project->save();
        $project->clients()->sync($request->client_id, true);
        $project->users()->sync($request->users, true);
        // $project->user()->sync($request->user, true);
        // $project->category()->sync($request->category_id, true);
        // $project->department()->sync($request->department_id, true);
  
        if ($project->save())
        {
            $project_id = $project->id;
            $project_details = [
                'clientName' => $request->clientName,
                'phone_number' => $request->phone_number,
                'productionTime' => $request->productionTime,
                'projectDirections' => $request->projectDirections,
                'invoiceTo' => $request->invoiceTo,
                'numberPersonnel' => $request->numberPersonnel,
                'projectedHrs' => $request->projectedHrs,
                'quotedDated' => $request->quotedDated,
                'quotedBy' => $request->quotedBy,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode];

            $project_detail = ProjectDetail::where('project_id', $project_id)->update($project_details);
        }


            Session::flash('success', 'Project Updated Successfully!');
            return redirect()->route('projects.show', $id);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        Session::flash('success', 'Project Deleted!');
        return redirect()->route('projects.index');
    }

    public function getTasklists($id)
    {   
        $project = Project::findOrFail($id);
        $tasklists = Tasklist::where('project_id', $id)->get();
        $users = User::whereHas('roles', function($q){
            $q->where('name','installer');
            })->get();

        $milestones = Milestone::where('project_id', $id)->get();
        $userPermission = Auth::user()->hasPermission('read-task');
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        
        $colors = Color::all();
                
        return view ('workcenter.projects.tasklists', compact('project', 'tasklists', 'milestones', 'users', 'colors', 'userPermission'));
    }

    public function addTasklist(Request $request)
    {   

        $this->validate($request, [
            'tasklistname' => 'required|min:3|max:100',
            'tasklistdetails' => 'sometimes',
            'start_date' => 'required',
            'end_date' => 'required',
            'color' => 'required',
            'users' => 'required'
        ]);

        $tasklist = new Tasklist();
        
        $tasklist->project_id = $request->project_id;
        $tasklist->milestone_id = $request->milestone_id;
        $tasklist->tasklistname = $request->tasklistname;
        $tasklist->tasklistdetails = $request->tasklistdetails;
        $tasklist->start_date = $request->start_date;
        $tasklist->end_date = $request->end_date;
        $tasklist->color = $request->color;
        $userID = $request->users;

        $users = User::findOrFail($userID);
        
        // dd($tasklist);
        $tasklist->save();
        $tasklist->projects()->sync($request->project_id, false);
        $tasklist->users()->sync($request->users, false);
        $tasklist->milestones()->sync($request->milestone_id, false);
  
        Notification::send($users, new TaskPosted($tasklist));
 
        Session::flash('success', 'Tasklist Created Successfully!');
        return redirect()->route('projects.tasklists', $tasklist->project_id);
    }

    public function showTask($id)
    {
        $task = Tasklist::findOrFail($id);
        // dd($task);
        $projectId = Tasklist::pluck('project_id', 'id')->get($id);
        // dd($projectId);
        $project = Project::findOrFail($projectId);
        // dd($project);
        $user = DB::table('tasklist_user')
                ->where('tasklist_user.tasklist_id', $id)
                ->get();
                // dd($user);
        $userPermission = Auth::user()->hasPermission('read-task');

        return view('workcenter.projects.showTask', compact('task', 'projectId', 'project', 'user', 'userPermission'));
    }

    public function getTasklistFiles($id)
    {   
        $tasklist = Tasklist::findOrFail($id);
        // dd($project);
        $project = Tasklist::pluck('project_id', 'id')->get($id);
        $taskfiles = TaskFile::where('tasklist_id', $id)->get();      
        // dd($milestones);
        return view ('workcenter.projects.tasklistfiles', compact('tasklist', 'taskfiles', 'project'));
    }

    public function uploadTaskFiles(Request $request)
    {
         // handle file upload
      if ($request->hasFile('tasklist_file')) {
        
        $this->validate($request, [
            'description' => 'sometimes',
            'tasklist_file' => 'required|file|max:1999'
          ]);

        $description = $request->description;
        
        // Get File name with the extension
        $fileNameWithExt = $request->file('tasklist_file')->getClientOriginalName();
       
        // Get Just filename
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // Get Just extension
        $extension = $request->file('tasklist_file')->getClientOriginalExtension();
        // Filename to Store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload File
        $path = $request->file('tasklist_file')->storeAs('public/documents', $fileNameToStore);

        $taskfile = new TaskFile();
        $taskfile->tasklist_id = $request->tasklist_id;
        $taskfile->project_id = $request->project_id;
        $taskfile->user_id = $request->user_id;
        $taskfile->description = $request->description;
        $taskfile->tasklist_file = $fileNameToStore;

        $taskfile->save();
        // $taskfile->projects()->sync($request->project_id, false);
        // $taskfile->users()->sync($request->user_id, false);

        Session::flash('success', 'File uploaded successfully!');

        return redirect()->route('projects.tasklistfiles', $request->tasklist_id);
        }
    }

    public function destroyTaskFile($id)
    {
        $file = TaskFile::findOrFail($id);
        $tasklist_id = TaskFile::pluck('tasklist_id', 'id')->get($id);
        // dd($file->id);
        Storage::delete('public/documents/'.$file->tasklist_file);
        $file->delete();

        Session::flash('success', 'File Deleted!');
        return redirect()->route('projects.tasklistfiles', $tasklist_id);
    }

    public function getEditTasklist($id)
    {
        $tasklist = Tasklist::findOrFail($id);
        $projectId = Tasklist::pluck('project_id', 'id')->get($id);
        $milestones = Milestone::where('project_id', $projectId)->get();
        $colors = Color::all();
        // dd($milestones);
        // $users = User::all();
        $users = User::whereHas('roles', function($q){
            $q->where('name','installer');
            })->get();

        $users2 = array();
        foreach ($users as $user) {
            $users2[$user->id] = $user->firstName .' '. $user->lastName;
        }
        
        // dd($users2[$user->id]);
        return view('workcenter.projects.editTasklist')
                ->withTasklist($tasklist)
                ->withProjectId($projectId)
                ->withUsers($users2)
                ->withMilestones($milestones)
                ->withColors($colors);
    }

    public function updateTasklist(Request $request, $id)
    {
        $this->validate($request, [
            'tasklistname' => 'required|min:3|max:100',
            'tasklistdetails' => 'sometimes',
            'start_date' => 'required',
            'end_date' => 'required',
            'color' => 'required',
            'active' => 'sometimes'
        ]);

        $tasklist = Tasklist::findOrFail($id);
              
        $tasklist->project_id = $request->project_id;
        $tasklist->milestone_id = $request->milestone_id;
        $tasklist->tasklistname = $request->tasklistname;
        $tasklist->tasklistdetails = $request->tasklistdetails;
        $tasklist->start_date = $request->start_date;
        $tasklist->end_date = $request->end_date;
        $tasklist->color = $request->color;
        $tasklist->active = $request->active;
        // $tasklist->milestone = $request->milestone;
        // dd($tasklist);
        $tasklist->save();

        $tasklist->projects()->sync($request->project_id, true);
        $tasklist->users()->sync($request->users, true);
        $tasklist->milestones()->sync($request->milestone_id, true);

        Session::flash('success', 'Tasklist Updated Successfully!');
        return redirect()->route('projects.tasklists', $tasklist->project_id);

    }

    public function updateTask(Request $request, $id)
    {   
        $task = Tasklist::findOrFail($id);
        $projectId = Tasklist::pluck('project_id', 'id')->get($id);

        $client_project = DB::table('client_project')
                    ->select('client_id')
                    ->where('project_id', $projectId)
                    ->first();
        $clientID = $client_project->client_id;
        
        $client = DB::table('users')
                    ->join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->where('users.id', $clientID)
                    ->first();

         // Send email to client when task completed
        $data = array(
            'sender' => Auth::user()->email,
            'firstName' => Auth::user()->firstName,
            'lastName' => Auth::user()->lastName,
            'email' => Auth::user()->email,
            'clientEmail' => $client->email,
            'clientFname' => $client->firstName,
            'clientLname' => $client->lastName,
            'taskDescription' => $task->tasklistdetails 
            );

        Mail::send('workcenter.emails.taskcompleted', $data, function($message) use($data) {
            $message->from($data['sender']);
            $message->to($data['clientEmail']);
            $message->subject('Task Completed');
        });
        
        // if the task is active its value is 1 in db
        // after updating it changes into green color
        if ($task->active == 1) {
        DB::table('tasklists')
            ->where('id', $task->id)
            ->update(['active' => '0', 'color' => '#008000']);

            Session::flash('success', 'Task Completed!');
            return redirect()->route('projects.tasklists', $task->project_id);
            
        // if the task is complete its value is 0 in db
        // after updating it changes into yellow color
        } elseif ($task->active == 0) {
            DB::table('tasklists')
            ->where('id', $task->id)
            ->update(['active' => '1', 'color' => '#FFFF00']);

            Session::flash('success', 'Task Not Completed!');
            return redirect()->route('projects.tasklists', $task->project_id);

        }         
    }

    public function destroyTasklist($id)
    {
        $tasklist = Tasklist::findOrFail($id);
        $project_id = Tasklist::pluck('project_id', 'id')->get($id);
        
        $tasklist->delete();
        Session::flash('success', 'Task Deleted!');
        return redirect()->route('projects.tasklists', $project_id);
    }


    public function getMilestones($id)
    {
        $project = Project::findOrFail($id);
        // dd($project);
        $tasklists = Tasklist::where('project_id', $id)->get();
        // dd($tasklists);
        $milestones = Milestone::where('project_id', $id)->get();
        $colors = Color::all();

        return view ('workcenter.projects.milestones', compact('project', 'tasklists', 'milestones', 'colors'));

    }

    public function addMilestone(Request $request)
    {
        $this->validate($request, [
            'milestoneName' => 'required|min:3|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'sometimes',
            'color' => 'required'
        ]);

        $milestone = new Milestone();
        
        $milestone->project_id = $request->project_id;
        $milestone->milestoneName = $request->milestoneName;
        $milestone->description = $request->description;
        $milestone->start_date = $request->start_date;
        $milestone->end_date = $request->end_date;
        $milestone->color = $request->color;
        
        // dd($tasklist);
        $milestone->save();
        $milestone->projects()->sync($request->project_id, false);

        Session::flash('success', 'Milestone Created Successfully!');
        return redirect()->route('projects.milestones', $milestone->project_id);
    }

    public function getEditMilestone($id)
    {
        $projectId = Milestone::pluck('project_id', 'id')->get($id);
        $milestone = Milestone::findOrFail($id);
        $colors = Color::all();
  
        return view('workcenter.projects.editMilestone')
                ->withProjectId($projectId)
                ->withMilestone($milestone)
                ->withColors($colors);
    }

    public function updateMilestone(Request $request, $id)
    {
        $this->validate($request, [
            'milestoneName' => 'required|min:3|max:100',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'sometimes',
            'color' => 'required'
        ]);

        $milestone = Milestone::findOrFail($id);
        
        $milestone->project_id = $request->project_id;
        $milestone->milestoneName = $request->milestoneName;
        $milestone->description = $request->description;
        $milestone->start_date = $request->start_date;
        $milestone->end_date = $request->end_date;
        $milestone->color = $request->color;
        
        // dd($tasklist);
        $milestone->save();
        $milestone->projects()->sync($request->project_id, true);

        Session::flash('success', 'Milestone updated Successfully!');
        return redirect()->route('projects.milestones', $milestone->project_id);

    }


    public function destroyMilestone($id)
    {
        $milestone = Milestone::findOrFail($id);
        $project_id = Milestone::pluck('project_id', 'id')->get($id);
        
        $milestone->delete();

        Session::flash('success', 'Milestone Deleted!');
        return redirect()->route('projects.milestones', $project_id);
    }

    public function getFiles($id)
    {
        $project = Project::findOrFail($id);
        // dd($project);
        $tasklists = Tasklist::where('project_id', $id)->get();
        // dd($tasklists);
        $milestones = Milestone::where('project_id', $id)->get();
        // dd($milestones);
        $files = File::where('project_id', $id)->get();
        // dd($files);
        return view ('workcenter.projects.files', compact('project', 'tasklists', 'milestones', 'files'));
    }

    public function uploadFile(Request $request)
    {   
        // dd($request);
        
        // handle file upload
      if ($request->hasFile('project_file')) {
        
        $this->validate($request, [
            'description' => 'sometimes',
            'project_file' => 'required|file|max:1999'
          ]);

        $description = $request->description;
        
        // Get File name with the extension
        $fileNameWithExt = $request->file('project_file')->getClientOriginalName();
       
        // Get Just filename
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // Get Just extension
        $extension = $request->file('project_file')->getClientOriginalExtension();
        // Filename to Store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload File
        $path = $request->file('project_file')->storeAs('public/documents', $fileNameToStore);

        $file = new File();
        $file->project_id = $request->project_id;
        $file->user_id = $request->user_id;
        $file->description = $request->description;
        $file->project_file = $fileNameToStore;

        $file->save();
        $file->projects()->sync($request->project_id, false);
        $file->users()->sync($request->user_id, false);

        Session::flash('success', 'File uploaded successfully!');

        return redirect()->route('projects.files', $file->project_id);
      }

    }

    public function destroyFile($id)
    {
        $file = File::findOrFail($id);
        $project_id = File::pluck('project_id', 'id')->get($id);
        
        Storage::delete('public/documents/'.$file->project_file);
        $file->delete();

        Session::flash('success', 'File Deleted!');
        return redirect()->route('projects.files', $project_id);
    }

    public function getDiscussions($id)
    {
        $project = Project::findOrFail($id);
        $posts = Discussion::where('project_id', $id)->orderBy('created_at', 'desc')->get();

        return view ('workcenter.projects.discussions', compact('project', 'posts'));
    }

    public function postDiscussion(Request $request)
    {   
        $this->validate($request, [
            'message' => 'required'
        ]);

        if (!empty($request->message)) {
            $post = new Discussion();

            $post->project_id = $request->project_id;
            $post->user_id = $request->user_id;
            $post->message = Purifier::clean($request->message);

            $post->save();
            $post->users()->sync($request->user_id, false);
            $post->projects()->sync($request->project_id, false);

            Session::flash('success', 'Discussion Posted!');
            return redirect()->route('projects.discussions', $post->project_id);
        } else {
            Session::flash('danger', 'Discussion not posted!');
            return redirect()->route('projects.discussions', $post->project_id);
        } 
        
    }

    public function getEditDiscussion($id)
    {   
        $post = Discussion::findOrFail($id);
        $project_id = Discussion::pluck('project_id', 'id')->get($id);
        $user_id = Discussion::pluck('user_id', 'id')->get($id);

        if ($user_id == Auth::user()->id){
            return view('workcenter.projects.editDiscussion', compact('post', 'project_id'));
        } else {
            return view('workcenter.errors.404');
        }
        
    }

    public function updateDiscussion (Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $post = Discussion::findOrFail($id);
        
        if (!empty($request->message)) {
            // $post->project_id = $request->project_id;
            // $post->user_id = $request->user_id;
            $post->message = Purifier::clean($request->message);
    
            $post->save();
            // $post->users()->sync($request->user_id, true);
            // $post->projects()->sync($request->project_id, true);
    
            Session::flash('success', 'Discussion Updated!');
            return redirect()->route('projects.discussions', $post->project_id);
        } else {
            Session::flash('danger', 'Discussion not posted!');
            return redirect()->route('projects.editDiscussion', $post->id);
        } 
        
    }

    public function destroyDiscussion ($id)
    {
        $post = Discussion::findOrFail($id);
        $post->delete();

        Session::flash('success', 'Discussion Deleted!');
        return redirect()->route('projects.discussions', $post->project_id);
    }

    
    public function getPunchTaskHours($id)
    {
        $project = Project::findOrFail($id);
        $tasklist = Tasklist::where('project_id', $project->id)->first();
        $users = DB::table('users')
                ->join('tasklist_user', 'users.id', '=', 'tasklist_user.user_id')
                ->select('users.*')
                ->get();
        // dd($users);
        return view('workcenter.projects.punchtaskhours', compact('project', 'tasklist', 'users'));
    }

    // Store Task Hours by supervisor on behalf of installers //
    public function storeTaskHoursBySupervisor(Request $request)
    {   
        $current = Carbon::now();
        if (!$request->travelIn && 
            !$request->travelOut && 
            !$request->installIn && !$request->installOut )
        {
            Session::flash('warning', 'Just Check one In/Out!');
            return redirect()->route('projects.tasklists', $request->project_id);

        } else {

            if (($request->travelIn  && $request->travelOut) || ($request->installIn && $request->installOut) ){

                Session::flash('warning', 'Just Check one In/Out!');
                return redirect()->route('projects.tasklists', $request->project_id);
    
            } else {
                
                if ($request->travelIn == 'travelIn') {
                $this->validate($request, [
                    'travelIn' => 'sometimes'
                ]);
    
                $punch = new PunchHour();
                $punch->project_id = $request->project_id;
                $punch->user_id = $request->user_id;
                // $punch->tasklist_id = $request->tasklist_id;
                $punch->travelIn = $current;
                $punch->save();
                
                Session::flash('success', 'Travel In time is registered!');
                return redirect()->route('projects.tasklists', $request->project_id);
                
            } elseif ($request->travelOut == 'travelOut') {
                    $punchId = DB::table('punch_hours')
                                ->select('punch_hours.id')
                                ->where('punch_hours.user_id', $request->user_id)
                                ->get();
                                // dd($punchId->id);
                    foreach ($punchId as $pid) {
                        $punchhours = DB::table('punch_hours')
                            ->select('punch_hours.*')
                            ->where('punch_hours.travelOut', null)
                            ->get();
                        // dd($punchhours);
                    }
                    foreach ($punchhours as $punchuser) {
                        // dd($pid->id);
                        if ($request->user_id == $punchuser->user_id){
                            $this->validate($request, [
                                'travelOut' => 'sometimes'
                            ]);
            
                            $punch = PunchHour::firstOrNew(array('id' => $pid->id));
                            $punch->travelOut = $current;
                            $punch->save();
                
                            Session::flash('success', 'Travel Out time is registered!');
                            return redirect()->route('projects.tasklists', $request->project_id);
                        }
                    }

            } elseif ($request->installIn == 'installIn') {

                $punchId = DB::table('punch_hours')
                                ->select('punch_hours.id')
                                ->where('punch_hours.user_id', $request->user_id)
                                ->get();
                                // dd($punchId->id);
                    foreach ($punchId as $pid) {
                        $punchhours = DB::table('punch_hours')
                            ->select('punch_hours.*')
                            ->where('punch_hours.installIn', null)
                            ->get();
                        // dd($punchhours);
                    }
                    foreach ($punchhours as $punchuser) {
                        if ($request->user_id == $punchuser->user_id) {
                            $this->validate($request, [
                                'installIn' => 'sometimes'
                            ]);
                
                            $punch = PunchHour::firstOrNew(array('id' => $pid->id));
                            $punch->installIn = $current;
                            $punch->save();
                
                            Session::flash('success', 'Installation time just started!');
                            return redirect()->route('projects.tasklists', $request->project_id);
                    }
                }
            } 

            elseif ($request->installOut == 'installOut') {

                $punchId = DB::table('punch_hours')
                                ->select('punch_hours.id')
                                ->where('punch_hours.user_id', $request->user_id)
                                ->get();
                                // dd($punchId->id);
                    foreach ($punchId as $pid) {
                        $punchhours = DB::table('punch_hours')
                            ->select('punch_hours.*')
                            ->where('punch_hours.installOut', null)
                            ->get();
                        // dd($punchhours);
                    }
                    foreach ($punchhours as $punchuser) {
                        if ($request->user_id == $punchuser->user_id) {
                            $this->validate($request, [
                                'installOut' => 'sometimes'
                            ]);
                
                            $punch = PunchHour::firstOrNew(array('id' => $pid->id));
                            $punch->installOut = $current;
                            $punch->save();
                
                            Session::flash('success', 'Install Out time is registered!');
                            return redirect()->route('projects.tasklists', $request->project_id);
                    }
                }            
    
            } 
          }
        }
    }

    // Store Task Hours //
    public function storeTaskHours(Request $request)
    {   
        $current = Carbon::now();
        if (!$request->travelIn && 
            !$request->travelOut && 
            !$request->installIn && !$request->installOut )
        {
            Session::flash('warning', 'Just Check one In/Out!');
            return redirect()->route('projects.punchtaskhours', $request->project_id);

        } else {

            if (($request->travelIn  && $request->travelOut) || ($request->installIn && $request->installOut) ){

                Session::flash('warning', 'Just Check one In/Out!');
                return redirect()->route('projects.punchtaskhours', $request->project_id);
    
            } else {
                
                if ($request->travelIn == 'travelIn') {
                $this->validate($request, [
                    'travelIn' => 'sometimes'
                ]);
    
                $punch = new PunchHour();
                $punch->project_id = $request->project_id;
                $punch->user_id = $request->user_id;
                // $punch->tasklist_id = $request->tasklist_id;
                $punch->travelIn = $current;
                $punch->save();
                
                Session::flash('success', 'Travel In time is registered!');
                return redirect()->route('projects.punchtaskhours', $request->project_id);
                
            } elseif ($request->travelOut == 'travelOut') {
                    $punchId = DB::table('punch_hours')
                                ->select('punch_hours.id')
                                ->where('punch_hours.user_id', $request->user_id)
                                ->get();
                                // dd($punchId->id);
                    foreach ($punchId as $pid) {
                        $punchhours = DB::table('punch_hours')
                            ->select('punch_hours.*')
                            ->where('punch_hours.travelOut', null)
                            ->get();
                        // dd($punchhours);
                    }
                    foreach ($punchhours as $punchuser) {
                        // dd($pid->id);
                        if ($request->user_id == $punchuser->user_id){
                            $this->validate($request, [
                                'travelOut' => 'sometimes'
                            ]);
            
                            $punch = PunchHour::firstOrNew(array('id' => $pid->id));
                            $punch->travelOut = $current;
                            $punch->save();
                
                            Session::flash('success', 'Travel Out time is registered!');
                            return redirect()->route('projects.punchtaskhours', $request->project_id);
                        }
                    }

            } elseif ($request->installIn == 'installIn') {

                $punchId = DB::table('punch_hours')
                                ->select('punch_hours.id')
                                ->where('punch_hours.user_id', $request->user_id)
                                ->get();
                                // dd($punchId->id);
                    foreach ($punchId as $pid) {
                        $punchhours = DB::table('punch_hours')
                            ->select('punch_hours.*')
                            ->where('punch_hours.installIn', null)
                            ->get();
                        // dd($punchhours);
                    }
                    foreach ($punchhours as $punchuser) {
                        if ($request->user_id == $punchuser->user_id) {
                            $this->validate($request, [
                                'installIn' => 'sometimes'
                            ]);
                
                            $punch = PunchHour::firstOrNew(array('id' => $pid->id));
                            $punch->installIn = $current;
                            $punch->save();
                
                            Session::flash('success', 'Installation time just started!');
                            return redirect()->route('projects.punchtaskhours', $request->project_id);
                    }
                }
            } 

            elseif ($request->installOut == 'installOut') {

                $punchId = DB::table('punch_hours')
                                ->select('punch_hours.id')
                                ->where('punch_hours.user_id', $request->user_id)
                                ->get();
                                // dd($punchId->id);
                    foreach ($punchId as $pid) {
                        $punchhours = DB::table('punch_hours')
                            ->select('punch_hours.*')
                            ->where('punch_hours.installOut', null)
                            ->get();
                        // dd($punchhours);
                    }
                    foreach ($punchhours as $punchuser) {
                        if ($request->user_id == $punchuser->user_id) {
                            $this->validate($request, [
                                'installOut' => 'sometimes'
                            ]);
                
                            $punch = PunchHour::firstOrNew(array('id' => $pid->id));
                            $punch->installOut = $current;
                            $punch->save();
                
                            Session::flash('success', 'Install Out time is registered!');
                            return redirect()->route('projects.punchtaskhours', $request->project_id);
                    }
                }            
    
            } 
          }
        }
    }

    public function getProjectbudget($id) 
    {
        $project = Project::findOrFail($id);
        $rates = Rate::all();
        $projectBudget = ProjectBudget::where('project_id', $id)->get();
        $input_rates = ProjectRate::where('project_id', $id)->get();
        $availableInventory = Inventory::all();
        $equipments = InventoryProject::where('project_id', $id)->get();

        $inventories = DB::table('inventories')
                ->join('inventory_project', 'inventories.id', '=', 'inventory_project.inventory_id')
                ->select('inventories.*')
                ->where('inventory_project.project_id', $id)
                ->get();
        // foreach ($inventories as $inventory) {
        //     $inventoryID = $inventory->inventory_id;
        // }
        // dd($inventories);
        $projectHours = DB::table('users')
                    ->join('punch_hours', 'users.id', '=', 'punch_hours.user_id')
                    ->join('projects', 'punch_hours.project_id', '=', 'projects.id')
                    ->select('users.*', 'projects.*', 'punch_hours.*')
                    ->where('punch_hours.project_id', $id)           
                    ->get();
        // dd($projectHours);
        $user = DB::table('punch_hours')
                ->selectRaw('punch_hours.user_id')
                ->where('punch_hours.project_id', $id)
                ->distinct('punch_hours.user_id')
                ->get();
                $u = $user->toArray();


        $projecthrs = DB::table('punch_hours')
                        ->select(DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(travelOut, travelIn))) as travel_hours,
                                    SUM(TIME_TO_SEC(TIMEDIFF(installOut, installIn))) as work_hours'))
                        ->where('project_id', $id)
                        ->get();
    // dd($projecthrs);
        foreach ($projecthrs as $hr) {
            $workHrs = $hr->work_hours;
            $travelHrs = $hr->travel_hours;

            // $workHrs = new Carbon(strtotime($hr->work_hours));
            // $travelHrs = new Carbon(strtotime($hr->travel_hours));
            // $overtimeHrs = new Carbon(strtotime($hr->overtime_hours));

        }
        // dd($travelHrs);
        $sumofhours = round(($workHrs + $travelHrs) / 3600, 2);
        $t = $workHrs + $travelHrs ;
        $officialTime = floor($t / 3600) . gmdate(":i:s", $t % 3600);
             
        // dd($totalhours);
        $sum = DB::table('project_budgets')
                ->select(DB::raw('SUM(total_hours+
                                      total_facility_management+
                                      total_margin+
                                      total_quote_time+
                                      total_project_management+
                                      total_travel+
                                      total_truck+
                                      total_van+
                                      total_fuel+
                                      total_hotel+
                                      total_perdiem+
                                      total_material+
                                      total_receiving+
                                      total_return) as total'))
                ->where('project_id', $id)
                ->groupBy('project_id')
                ->get();

                
        return view('workcenter.projects.projectbudget', compact('project', 
                                                        'rates', 'input_rates', 'projectBudget', 
                                                        'sum', 'sumofhours', 'officialTime', 'inventories', 
                                                        'equipments', 'inventory', 'availableInventory'));
    }

    public function inputRates(Request $request)
    {
   
        if ($request->input_facility_management || 
                        $request->input_margin || 
                        $request->input_quote_time || 
                        $request->input_project_management || 
                        $request->input_travel || 
                        $request->input_truck || 
                        $request->input_van ||
                        $request->input_fuel ||
                        $request->input_hotel || 
                        $request->input_perdiem ||
                        $request->input_material ||
                        $request->input_receiving ||
                        $request->input_hour ||
                        $request->input_return) {
            $this->validate($request, [
                'input_hour' => 'sometimes',
                'input_facility_management' => 'sometimes',
                'input_margin' => 'sometimes',
                'input_quote_time' => 'sometimes',
                'input_project_management' => 'sometimes',
                'input_travel' => 'sometimes',
                'input_truck' => 'sometimes',
                'input_van' => 'sometimes',
                'input_fuel' => 'sometimes',
                'input_hotel' => 'sometimes',
                'input_perdiem' => 'sometimes',
                'input_material' => 'sometimes',
                'input_receiving' => 'sometimes',
                'input_return' => 'sometimes'  
            ]);
        
            $input_rate = ProjectRate::firstOrNew(array('project_id' => $request->project_id));

            $input_rate->project_id = $request->project_id;
            $input_rate->input_hour = $request->input_hour;
            $input_rate->input_facility_management = $request->input_facility_management;
            $input_rate->input_margin = $request->input_margin;
            $input_rate->input_quote_time = $request->input_quote_time;
            $input_rate->input_project_management = $request->input_project_management;
            $input_rate->input_travel = $request->input_travel;
            $input_rate->input_truck = $request->input_truck;
            $input_rate->input_van = $request->input_van;
            $input_rate->input_fuel = $request->input_fuel;
            $input_rate->input_hotel = $request->input_hotel;
            $input_rate->input_perdiem = $request->input_perdiem;
            $input_rate->input_material = $request->input_material;
            $input_rate->input_receiving = $request->input_receiving;
            $input_rate->input_return = $request->input_return;

            $input_rate->save();
        } 
        
        $rates = Rate::all();
        foreach ($rates as $rate) {}
        $hour = $rate->hour;
        $facility_management = $rate->facility_management;
        $margin = $rate->margin;
        $quote_time = $rate->quote_time;
        $project_management = $rate->project_management;
        $travel = $rate->travel;
        $truck = $rate->truck;
        $van = $rate->van;
        $fuel = $rate->fuel;
        $hotel = $rate->hotel;
        $perdiem = $rate->perdiem;
        $material = $rate->material;
        $receiving = $rate->receiving;
        $return = $rate->return;

        if ($input_rate->save())
        {
            $project_id = $request->project_id;
            $data = [
                'project_id' => $project_id,
                'total_hours' => $request->input_hour * $hour,
                'total_facility_management' => $request->input_facility_management * $facility_management,
                'total_margin' => $request->input_margin * $margin,
                'total_quote_time' => $request->input_quote_time * $quote_time,
                'total_project_management' => $request->input_project_management * $project_management,
                'total_travel' => $request->input_travel * $travel,
                'total_truck' => $request->input_truck * $truck,
                'total_van' => $request->input_van * $van,
                'total_fuel' => $request->input_fuel * $fuel,
                'total_hotel' => $request->input_hotel * $hotel,
                'total_perdiem' => $request->input_perdiem * $perdiem,
                'total_material' => $request->input_material * $material,
                'total_receiving' => $request->input_receiving * $receiving,
                'total_return' => $request->input_return * $return
            ];
            
            $total = ProjectBudget::where('project_id', $project_id)->insert($data);
        }

        Session::flash('success', 'Project Rates Saved!');
        return redirect()->route('projects.projectbudget', $request->project_id);
    }

  
    public function updateProjectRates(Request $request, $id)
    {   
        
        if ($request->input_facility_management || 
                        $request->input_margin || 
                        $request->input_quote_time || 
                        $request->input_project_management || 
                        $request->input_travel || 
                        $request->input_truck || 
                        $request->input_van ||
                        $request->input_fuel ||
                        $request->input_hotel || 
                        $request->input_perdiem ||
                        $request->input_material ||
                        $request->input_receiving ||
                        $request->input_hour ||
                        $request->input_return) {
            $this->validate($request, [
                'input_hour' => 'sometimes',
                'input_facility_management' => 'sometimes',
                'input_margin' => 'sometimes',
                'input_quote_time' => 'sometimes',
                'input_project_management' => 'sometimes',
                'input_travel' => 'sometimes',
                'input_truck' => 'sometimes',
                'input_van' => 'sometimes',
                'input_fuel' => 'sometimes',
                'input_hotel' => 'sometimes',
                'input_perdiem' => 'sometimes',
                'input_material' => 'sometimes',
                'input_receiving' => 'sometimes',
                'input_return' => 'sometimes'  
            ]);
        
            $input_rate = ProjectRate::firstOrNew(array('project_id' => $request->project_id));

            $input_rate->project_id = $request->project_id;
            $input_rate->input_hour = $request->input_hour;
            $input_rate->input_facility_management = $request->input_facility_management;
            $input_rate->input_margin = $request->input_margin;
            $input_rate->input_quote_time = $request->input_quote_time;
            $input_rate->input_project_management = $request->input_project_management;
            $input_rate->input_travel = $request->input_travel;
            $input_rate->input_truck = $request->input_truck;
            $input_rate->input_van = $request->input_van;
            $input_rate->input_fuel = $request->input_fuel;
            $input_rate->input_hotel = $request->input_hotel;
            $input_rate->input_perdiem = $request->input_perdiem;
            $input_rate->input_material = $request->input_material;
            $input_rate->input_receiving = $request->input_receiving;
            $input_rate->input_return = $request->input_return;

            $input_rate->save();
        } 
        
        $rates = Rate::all();
        foreach ($rates as $rate) {}
        $hour = $rate->hour;
        $facility_management = $rate->facility_management;
        $margin = $rate->margin;
        $quote_time = $rate->quote_time;
        $project_management = $rate->project_management;
        $travel = $rate->travel;
        $truck = $rate->truck;
        $van = $rate->van;
        $fuel = $rate->fuel;
        $hotel = $rate->hotel;
        $perdiem = $rate->perdiem;
        $material = $rate->material;
        $receiving = $rate->receiving;
        $return = $rate->return;

        if ($input_rate->save())
        {
            $project_id = $request->project_id;
            $data = [
                'project_id' => $project_id,
                'total_hours' => $request->input_hour * $hour,
                'total_facility_management' => $request->input_facility_management * $facility_management,
                'total_margin' => $request->input_margin * $margin,
                'total_quote_time' => $request->input_quote_time * $quote_time,
                'total_project_management' => $request->input_project_management * $project_management,
                'total_travel' => $request->input_travel * $travel,
                'total_truck' => $request->input_truck * $truck,
                'total_van' => $request->input_van * $van,
                'total_fuel' => $request->input_fuel * $fuel,
                'total_hotel' => $request->input_hotel * $hotel,
                'total_perdiem' => $request->input_perdiem * $perdiem,
                'total_material' => $request->input_material * $material,
                'total_receiving' => $request->input_receiving * $receiving,
                'total_return' => $request->input_return * $return
            ];
            
            $total = ProjectBudget::where('project_id', $project_id)->update($data);
        }

        Session::flash('success', 'Project Rates Updated!');
        return redirect()->route('projects.projectbudget', $request->project_id);
    }

   public function storeTCO(Request $request, $id)
   {
       $validator = Validator::make($request->all(), [
            'tco_date' => 'required|date',
            'notes' => 'sometimes'
       ]);

       if ($validator->fails()) {
        return redirect('workcenter/projects/projectbudget/'.$id)
                    ->withErrors($validator)
                    ->withInput();
       } else {

            $tco = new TCO();
            $tco->project_id = $request->project_id;
            $tco->tco_date = $request->tco_date;
            $tco->notes = $request->notes;

            $tco->save();

            Session::flash('success', 'TCO Deadline Saved');
            return redirect('workcenter/projects/'.$id);
       }
   }

   public function destroyTco($id)
   {
       $tco = TCO::findOrFail($id);
       $tco->delete();

       Session::flash('success', 'TCO Deleted');
       return redirect('workcenter/projects/'.$tco->project_id);
   }
}