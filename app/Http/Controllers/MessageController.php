<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\MessagePosted;
use Notification;
use Carbon\Carbon;
use App\User;
use App\Message;
use Validator;
use Session;
use Purifier;
use Auth;
use DB;

class MessageController extends Controller
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
        $messages = Message::orderBy('id', 'desc')->paginate(10);
        // dd($messages);
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

        // These variables are defiend in AppServiceProvider
        // $notSeenMessages = DB::table('messages')
        //             ->select(DB::raw('count(*) as notSeen, seen, recipient_id'))
        //             ->where('seen', '=', 1)
        //             ->groupBy('seen', 'recipient_id')
        //             ->get();
        // $seenMessages = DB::table('messages')
        //             ->select(DB::raw('count(*) as seen, seen, recipient_id'))
        //             ->where('seen', '=', 0)
        //             ->groupBy('seen', 'recipient_id')
        //             ->get();
                    // dd($notSeenMessages);
        return view('workcenter.messages.index', compact('messages', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        
        return view('workcenter.messages.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'recipient' => 'required',
            'subject' => 'sometimes',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('workcenter/messages/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {
           
            $message = New Message();

            $recipient = $request->recipient;
           
            $user = User::findOrFail($recipient);
            
            $userArray = $user->toArray();
            
            $firstName = $userArray['firstName'];
            $lastName = $userArray['lastName'];
            $fullName = $firstName.' '.$lastName;
            
            $message->user_id = $request->user_id;
            $message->sender = $request->sender;
            $message->recipient =  $fullName;
            $message->recipient_id = $recipient;
            // $message->recipients =  implode(';',$recipients);
            $message->subject = $request->subject;
            $message->message = $request->message;
            // dd($message);
            $message->save();
            $message->users()->sync($user, false);

            // Notification::send($users, new MessagePosted($message));

            Session::flash('success', 'Your Message has been Sent.');
            return redirect()->route('messages.create');
           
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
        $message = Message::findOrFail($id);
        return view('workcenter.messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        DB::table('messages')
            ->where('id', $message->id)
            ->update(['seen' => '0', 'read_at' => Carbon::now()]);

        /*Session::flash('success', 'The reservation is completed');*/
        return redirect()->route('messages.show', $message->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        Session::flash('success', 'Message Deleted.');
        return redirect()->route('messages.index');
    }
}
