<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave;
use App\User;
use Validator;
use Session;
use Auth;
use Calendar;
use Event;

class LeaveController extends Controller
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
        $leaves = Leave::orderBy('id', 'asc')->get();
        return view ('workcenter.rto.index', compact('users', 'leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

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
            'reason' => 'required',
            'user_id' => 'required'
        ]);
        // $this->validate($request, [
               
        // ]);
        if ($validator->fails()) {
            return redirect('workcenter/rto')
                        ->withErrors($validator)
                        ->withInput();
        } else {
             // $data = array(
            //     'start_date' => $request->start_date,
            //     'start_time' => $request->start_time,
            //     'end_date' => $request->end_date,
            //     'end_time' => $request->end_time,
            //     'reason' => $request->reason
            // );
            // dd($data);

            $leave = New Leave();
                        
            $leave->user_id = $request->user_id;
            $user = User::where('id', $leave->user_id)->get();
            $usersArray = $user->toArray();
            foreach($usersArray as $userDetails) {
                $firstName = $userDetails['firstName'];
                $lastName = $userDetails['lastName'];
            }
            $fullName = $firstName.' '.$lastName;
            $leave->fullName = $fullName;
            $leave->start_date = $request->start_date;
            $leave->start_time = $request->start_time;
            $leave->end_date = $request->end_date;
            $leave->end_time = $request->end_time;
            $leave->reason = $request->reason;

            $leave->save();
            $leave->users()->sync($request->user_id, false);

            Session::flash('success', 'Your Request has been submitted, Thank you');
            return redirect()->route('rto.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $users = User::all();
        
        return view('workcenter.rto.edit', compact('leave', 'users'));
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
        $validator = Validator::make($request->all(),[
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required|date|after:start_date',
            'end_time' => 'required',
            'reason' => 'required',
            'status' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/rto')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $leave = Leave::findOrFail($id);
                        
            $leave->user_id = $request->user_id;
            $leave->start_date = $request->start_date;
            $leave->start_time = $request->start_time;
            $leave->end_date = $request->end_date;
            $leave->end_time = $request->end_time;
            $leave->reason = $request->reason;
            $leave->status = $request->status;

            $leave->save();
            $leave->users()->sync($request->user_id, true);

            Session::flash('success', 'The Request has been updated!');
            return redirect()->route('rto.index');
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
        $leave = Leave::findOrFail($id);
        $leave->delete();

        Session::flash('success', 'Leave Deleted!');
        return redirect()->route('rto.index');
    }

    
}
