<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\State;
use App\Address;
use App\Profile;
use App\Department;
use App\Project;
use App\Tasklist;
use App\Leave;
use App\Attendance;
use App\Performance;
use Validator;
use Session;
use Auth;
use Hash;
use DB;
use Calendar;
use Event;
use Image;

class MyAccountController extends Controller
{
    public function __construct() {

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $tasklists = Tasklist::all();
        return view('workcenter.myaccount.index', array('user' => Auth::user()))->withTasklists($tasklists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required|date|after:start_date',
            'end_time' => 'required',
            'reason' => 'required' 
        ]);
        
               
        // ]);
        if ($validator->fails()) {
            return redirect('workcenter/myaccount')
                        ->withErrors($validator)
                        ->withInput();
        } else {
  
            $leave = New Leave();
            $user_id = Auth::user()->id;
            
            $leave->user_id = $user_id;
            $leave->fullName = $request->fullName;
            $leave->start_date = $request->start_date;
            $leave->start_time = $request->start_time;
            $leave->end_date = $request->end_date;
            $leave->end_time = $request->end_time;
            $leave->reason = $request->reason;

            $leave->save();
            $leave->users()->sync($user_id, false);

            Session::flash('success', 'Your Request has been submitted, Thank you');
            return redirect()->route('myaccount.index');
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
        $leave = Leave::findOrFail($id);
        return view('workcenter.myaccount.show', compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $loggedId = Auth::id();
        // dd($loggedId);
        $user = User::findOrFail($id);
        // dd($user);
        $roles = Role::all();
        $states = State::pluck('state', 'state');
        $userAddress = $user->address;
        // dd($userAddress);
        return view('workcenter.myaccount.edit', array('user' => Auth::user()), compact('user','roles', 'states', 'userAddress'));
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
        $this->validate($request, [
            'firstName' => 'required|max:255',
            'middleName' => 'sometimes',
            'lastName' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id

          ]);

            $user = User::findOrFail($id);

            $user->firstName = $request->firstName;
            $user->middleName = $request->middleName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;

            if ($request->password_options == 'auto') {
                $password = $request->auto_password;
                $user->password = Hash::make($password);
            } elseif ($request->password_options == 'manual') {
                $this->validate($request, [
                  'password' => 'required|min:5|confirmed',
                  'password_confirmation' => 'required|min:5'
                ]);
                $user->password = Hash::make($request->password);
            }
            $user->save();

            if ($user->save()) {
                $user_id = $user->id;
                $data = [
                        'phone_number' => $request->phone_number,
                        'address1' => $request->address1,
                        'address2' => $request->address2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zipcode' => $request->zipcode];
       
                $address = Address::where('user_id', $user_id)->update($data);
       
            }

            Session::flash('success', 'Your Profile has been updated Successfuly!');
            return redirect()->route('myaccount.index');
    }

    public function getAvatar($id)
    {
        return view('workcenter.myaccount.avatar', array('user' => Auth::user()));
    }

    public function storeAvatar(Request $request)
    {   
        
        if ($request->hasFile('avatar'))
        {
            $this->validate($request, [
                'avatar' => 'required|image|max:1999'
              ]);

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename) );

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
            
        }
        return view('workcenter.myaccount.avatar', array('user' => Auth::user()));
    }

    public function getMyTasks($id)
    {   
        $today = Carbon::today();
  
        $user = User::FindOrFail($id);
        $tasklists = DB::table('tasklists')
                    ->join('tasklist_user', 'tasklists.id', '=', 'tasklist_user.tasklist_id')
                    ->where('tasklist_user.user_id', $id)
                    ->whereDate('tasklists.start_date', $today)
                    ->get();
                    // dd($tasklists);
        $tasklistArray = $tasklists->toArray();
        $myRto = Leave::where('user_id', $id)
                        ->where('status', '=', 'approved')
                        ->get();
        $myRtoArray =  $myRto->toArray();    
        $user->unreadNotifications->markAsRead();           
  
        $rto_details = [];
        $tasklist_details = [];
        foreach ($tasklistArray as $tasklist) {
            $tasklist_details[] = Calendar::event(
                $tasklist->tasklistname,
                true,
                new \DateTime($tasklist->start_date),
                new \DateTime($tasklist->end_date .' +1 day'),
                $tasklist->id,
                [
                    'url' => 'http://localhost:8000/workcenter/projects/tasklists/'.$tasklist->project_id,
                    'color' => $tasklist->color
                ]
            );
        }

        foreach ($myRtoArray as $myrto) {
            $rto_details[] = Calendar::event(
                $myrto['reason'],
                true,
                new \DateTime($myrto['start_date']),
                new \DateTime($myrto['end_date'] .' +1 day'),
                $myrto['id'],
                [
                    'url' => 'http://localhost:8000/workcenter/myaccount/'.$myrto['id'],
                    'color' => "#2e29bc"
                ]
            );
        }
        $tasklistEvent = Calendar::addEvents($tasklist_details);
        $myRtoEvent = Calendar::addEvents($rto_details);
        return view ('workcenter.myaccount.mytasks', array('user' => Auth::user()))
                    ->withTasklists($tasklists)
                    ->withTasklistEvent($tasklistEvent)
                    ->withMyRtoEvent($myRtoEvent);
        // return view('workcenter.projects.tasklists', array('user' => Auth::user()));
    }

   public function myperformance($id)
   {
        $employee = User::findOrFail($id);
        $performances = Performance::where('user_id', $id)->get();
        return view('workcenter.myaccount.myperformance', compact('performances', 'employee'));
   }

   public function viewperformance($id)
   {
        $performance = Performance::where('id', $id)->first();

            $a = $performance->job_knowledge;
            $b = $performance->work_quality;
            $c = $performance->attendance_punctuality;
            $d = $performance->initiative;
            $e = $performance->comm_listening;
            $f = $performance->dependability;

            $average = ((($a + $b + $c + $d + $e + $f) / 30) * 100);
         
        return view('workcenter.myaccount.viewperformance', compact('performance', 'average'));
   }

   public function editperformance($id)
   {
        $performance = Performance::where('id', $id)->first();
        return view('workcenter.myaccount.editperformance', compact('performance'));
   }

   public function updateperformance(Request $request, $id)
   {
       $validator = Validator::make($request->all(), [
        'employee_signature' => 'required|min:5',
        'employee_date' => 'required'
       ]);

       if ($validator->fails()) {
        return redirect('workcenter/myaccount/editperformance/'.$id)
                    ->withErrors($validator)
                    ->withInput();
        } else {

            $performance = Performance::firstOrNew(array('id' => $id));
            $performance->employee_signature = $request->employee_signature;
            $performance->employee_date = $request->employee_date;
            // dd($performance);
            $performance->save();

            $user_id = Performance::pluck('user_id', 'id')->get($id);
        
            Session::flash('success', 'Performance review saved.');
            return redirect()->route('myaccount.myperformance', $user_id);
        }
   }
    
}
