<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;
use App\State;
use App\Address;
use App\Project;
use App\Profile;
use App\Client;
use DB;
use Session;
use Hash;
use Mail;
use Auth;

class ClientController extends Controller
{
    public function __construct(User $client, Address $address)
    {
        $this->middleware('auth');
        $this->client = $client;
        $this->address = $address;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $clients = Role::where('name','client')->first()->users()->get();
        return view ('workcenter.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $states = State::pluck('state', 'state');
        return view('workcenter.clients.create')
                ->withRoles($roles)
                ->withPermissions($permissions)
                ->withStates($states);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|max:255',
            'lastName' => 'sometimes|max:255',
            'email' => 'required|email|unique:users'
            ]);
 
          if (!empty($request->password)) {
            $this->validate($request, [
              'password' => 'required|min:5|confirmed',
              'password_confirmation' => 'required|min:5'
            ]);
            $password = trim($request->password);
 
          } else {
            # set the Auto Password
            $password = $request->auto_password;
           //  dd($password);
          }
          
          $data = array(
            'sender' => Auth::user()->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $password
            );
            
          $client = new User();
          
          $client->firstName = $request->firstName;
        //   $client->middleName = $request->middleName;
          $client->lastName = $request->lastName;
          $client->email = $request->email;
          $client->password = Hash::make($password);
         //  dd($client);
          $client->save();

        //    if ($client->save()) {
                
        //         Mail::send('workcenter.emails.client', $data, function($message) use($data) {
        //             $message->from($data['sender']);
        //             $message->to($data['email']);
        //             $message->subject('Welcome To Nebo Express');
        //             // $message->subject($data['firstName']);
        //         });
        //    }

          if ($client->save()) {
            $client_id = $client->id;
            $address_data = [
                   'user_id' => $client_id,
                   'phone_number' => $request->phone_number,
                   'address1' => $request->address1,
                   'address2' => $request->address2,
                   'city' => $request->city,
                   'state' => $request->state,
                   'zipcode' => $request->zipcode];
              
           $address = Address::where('user_id', $client_id)->insert($address_data);

         }
         if ($request->roles) {
            $client->syncRoles(explode(',', $request->roles));
         }         
           if ($request->permissions) {
              $client->syncPermissions(explode(',', $request->permissions));
           }
 
           if ($client->save()) {
 
             Session::flash('success', 'The account has been created Successfuly!');
             return redirect()->route('clients.index');
          } else {
            Session::flash('danger', 'Sorry a problem occured while creating this user');
            return redirect()->route('clients.create');
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
        $client = User::where('id', $id)->with('roles')->with('address')->first();
        
        $projects = DB::table('projects')
                    ->join('client_project', 'projects.id', '=', 'client_project.project_id')
                    ->where('client_project.client_id', $id)
                    ->get();
        return view('workcenter.clients.show')->withClient($client)->withProjects($projects);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = User::find($id);
        $roles = Role::all();
        $states = State::pluck('state', 'state');
        $clientAddress =$client->address;

        $client = User::where('id', $id)->with('roles')->first();
        
        return view('workcenter.clients.edit')
                ->withClient($client)
                ->withRoles($roles)
                ->withStates($states)
                ->withClientAddress($clientAddress);
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
            'lastName' => 'sometimes|max:255',
            'email' => 'required|email|unique:users,email,'.$id
          ]);
   
          $client = User::findOrFail($id);
          $client->firstName = $request->firstName;
        //   $client->middleName = $request->middleName;
          $client->lastName = $request->lastName;
          $client->email = $request->email;
          if ($request->password_options == 'auto') {
              $password = $request->auto_password;
              $client->password = Hash::make($password);
          } elseif ($request->password_options == 'manual') {
              $this->validate($request, [
                'password' => 'required|min:5|confirmed',
                'password_confirmation' => 'required|min:5'
              ]);
              $client->password = Hash::make($request->password);
          }
          $client->save();
   
          if ($client->save()) {
            $client_id = $client->id;
            $data = [
                    'phone_number' => $request->phone_number,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zipcode' => $request->zipcode];

   
            $address = Address::where('user_id', $client_id)->update($data);
   
          }
   
   
          if (empty($request->roles))
          {
            $client->detachRole($request->roles);
          } else {
              $client->syncRoles(explode(',', $request->roles));
          }
   
          if (empty($request->permissions))
          {
             $client->detachPermission($request->permissions);
          } else {
             $client->syncPermissions(explode(',', $request->permissions));
          }
   
          Session::flash('success', 'Client Profile has been updated Successfuly!');
          return redirect()->route('clients.show', $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = User::findOrFail($id);
        $address = Address::where('user_id', $id);
        $client->delete();
        $address->delete();

        Session::flash('success', 'Successfuly Deleted the account!');
        return redirect()->route('clients.index');

        // $clientProject = DB::table('client_project')
        //                 ->select('client_project.project_id')
        //                 ->where('client_project.client_id', $id)
        //                 ->first();
        //                 // dd($clientProject->project_id);
        // if (!empty($clientProject->project_id)) {

        //     Session::flash('danger', 'This account has a project related, delete the project first!');
        //     return redirect()->route('clients.show', $id);

        // } else if (empty($clientProject->project_id)) {

        //     $address = Address::where('user_id', $id);
        //     $client->delete();
        //     $address->delete();

        //     Session::flash('success', 'Successfuly Deleted the account!');
        //     return redirect()->route('clients.index');
        // }
        
    }

    public function myaccount($id)
    {
        $client = User::findOrFail($id);
        return view('workcenter.clients.myaccount', compact('client'));
    }

    public function geteditaccount($id)
    {
        $client = User::findOrFail($id);
        $states = State::pluck('state', 'state');
        $clientAddress =$client->address;

        // $client = User::where('id', $id)->with('roles')->first();
        
        return view('workcenter.clients.editaccount')
                ->withClient($client)
                ->withStates($states)
                ->withClientAddress($clientAddress);
    }

    public function updateAccount(Request $request, $id)
    {
        $this->validate($request, [
            'firstName' => 'required|max:255',
            'lastName' => 'sometimes',
            'email' => 'required|email|unique:users,email,'.$id

          ]);

            $client = User::findOrFail($id);

            $client->firstName = $request->firstName;
            // $client->middleName = $request->middleName;
            $client->lastName = $request->lastName;
            $client->email = $request->email;

            if ($request->password_options == 'auto') {
                $password = $request->auto_password;
                $client->password = Hash::make($password);
            } elseif ($request->password_options == 'manual') {
                $this->validate($request, [
                  'password' => 'required|min:5|confirmed',
                  'password_confirmation' => 'required|min:5'
                ]);
                $client->password = Hash::make($request->password);
            }
            $client->save();

            if ($client->save()) {
                $client_id = $client->id;
                $data = [
                        'phone_number' => $request->phone_number,
                        'address1' => $request->address1,
                        'address2' => $request->address2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zipcode' => $request->zipcode];
       
                $address = Address::where('user_id', $client_id)->update($data);
       
            }

            Session::flash('success', 'Your Profile has been updated Successfuly!');
            return redirect()->route('clients.myaccount', $client_id);
    }
    
}
