<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;
use App\State;
use App\Address;
use App\Project;
use App\Department;
use App\Profile;
use DB;
use Session;
use Hash;
use Mail;
use Auth;

class UserController extends Controller
{
    public function __construct(User $user, Address $address, Profile $profile)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->address = $address;
        $this->profile = $profile;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // $users = User::all();
        // $users = Role::where('name','superadministrator')->first()->users()->get();
        $users = User::whereHas('roles', function($q){
          $q->where('name', 'superadministrator')
            ->orWhere('name','administrator')
            ->orWhere('name', 'office-manager')
            ->orWhere('name','manager')
            ->orWhere('name','supervisor')
            ->orWhere('name','installer')
            ->orWhere('name','employee');
          })->get();
        $profiles = Profile::all();
        // dd($profiles);
        return view('workcenter.users.index')->withUsers($users)->withProfiles($profiles);
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
      $departments = Department::all(); 
      return view('workcenter.users.create')
              ->withRoles($roles)
              ->withPermissions($permissions)
              ->withStates($states)
              ->withDepartments($departments);
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
         $this->validate($request, [
           'firstName' => 'required|max:255',
           'middleName' => 'sometimes',
           'lastName' => 'required|max:255',
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
          
         $user = new User();
         $user->firstName = $request->firstName;
         $user->middleName = $request->middleName;
         $user->lastName = $request->lastName;
         $user->email = $request->email;
         $user->password = Hash::make($password);
        //  dd($user);
         $user->save();
         $user->department()->sync($request->department_id, false);

         if ($user->save()) {
                
          Mail::send('workcenter.emails.user', $data, function($message) use($data) {
              $message->from($data['sender']);
              $message->to($data['email']);
              $message->subject('Your Account is Created');
              // $message->subject($data['firstName']);
          });
     }

         if ($user->save()) {
            $user_id = $user->id;
            $address_data = [
                   'user_id' => $user_id,
                   'phone_number' => $request->phone_number,
                   'address1' => $request->address1,
                   'address2' => $request->address2,
                   'city' => $request->city,
                   'state' => $request->state,
                   'zipcode' => $request->zipcode];
              
            $profile_data = [
                  'user_id' => $user_id,
                  'status' => $request->status,
                  'employeeType' => $request->employeeType,
                  'hireDate' => $request->hireDate,
                  'payrate' => $request->payrate,
                  'notes' => $request->notes];
                     
           $address = Address::where('user_id', $user_id)->insert($address_data);
           $profile = Profile::where('user_id', $user_id)->insert($profile_data);
         }
    
         if ($request->roles) {
            $user->syncRoles(explode(',', $request->roles));
         }
          if ($request->permissions) {
             $user->syncPermissions(explode(',', $request->permissions));
          }

          if ($user->save()) {

            Session::flash('success', 'The account has been created Successfuly!');
            return redirect()->route('users.show', $user->id);
         } else {
           Session::flash('danger', 'Sorry a problem occured while creating this user');
           return redirect()->route('users.create');
          }
     }


    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //       'first_name' => 'required|max:255',
    //       'last_name' => 'required|max:255',
    //       'email' => 'required|email|unique:users'
    //     ]);
    //
    //     if (!empty($request->password)) {
    //       $this->validate($request, [
    //         'password' => 'required|min:5|confirmed',
    //         'password_confirmation' => 'required|min:5'
    //       ]);
    //       $password = trim($request->password);
    //
    //     } else {
    //       # set the Auto Password
    //       $length = 10;
    //       $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //       $str = '';
    //       $max = mb_strlen($keyspace, '8bit') -1;
    //       for ($i = 0; $i < $length; ++$i) {
    //         $str .= $keyspace[random_int(0, $max)];
    //       }
    //       $password = $str;
    //       // dd($password);
    //     }
    //     $user = new User();
    //     $user->first_name = $request->first_name;
    //     $user->last_name = $request->last_name;
    //     $user->email = $request->email;
    //     $user->password = Hash::make($password);
    //     $user->save();
    //
    //     if ($request->roles) {
    //       $user->syncRoles(explode(',', $request->roles));
    //     }
    //
    //     return redirect()->route('users.show', $user->id);
    //     // if ($user->save()) {
    //     //   return redirect()->route('users.show', $user->id);
    //     // } else {
    //     //   Session::flash('danger', 'Sorry a problem occured while creating this user');
    //     //   return redirect()->route('users.create');
    //     // }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::where('id', $id)->with('roles')->with('address')->first();
      return view('workcenter.users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::find($id);
      $roles = Role::all();
      $permissions = Permission::all();
      $states = State::pluck('state', 'state');
      $departments = Department::all();
      $userAddress =$user->address;
      $userProfile = $user->profile;
      // $selectedProfile = Profile::first()->user_id;
      // $userDepartment= Department::pluck('departmentTitle', 'id');
      // dd($selectedprofile);
      $user = User::where('id', $id)->with('roles')->with('permissions')->first();
      
      return view('workcenter.users.edit')
              ->withUser($user)
              ->withRoles($roles)
              ->withStates($states)
              ->withDepartments($departments)
              ->withPermissions($permissions)
              ->withUserAddress($userAddress)
              ->withUserProfile($userProfile);
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
       $user->department()->sync($request->department_id, true);

       if ($user->save()) {
         $user_id = $user->id;
         $data = [
                 'phone_number' => $request->phone_number,
                 'address1' => $request->address1,
                 'address2' => $request->address2,
                 'city' => $request->city,
                 'state' => $request->state,
                 'zipcode' => $request->zipcode];
         $profile_data = [
                  'user_id' => $user_id,
                  'status' => $request->status,
                  'employeeType' => $request->employeeType,
                  'hireDate' => $request->hireDate,
                  'payrate' => $request->payrate,
                  'notes' => $request->notes];

         $address = Address::where('user_id', $user_id)->update($data);
         $profile = Profile::where('user_id', $user_id)->update($profile_data);

       }


       if (empty($request->roles))
       {
         $user->detachRole($request->roles);
       } else {
           $user->syncRoles(explode(',', $request->roles));
       }

       if (empty($request->permissions))
       {
          $user->detachPermission($request->permissions);
       } else {
          $user->syncPermissions(explode(',', $request->permissions));
       }

       Session::flash('success', 'User Profile has been updated Successfuly!');
       return redirect()->route('users.show', $id);
       // if () {
       //   return redirect()->route('users.show', $id);
       // } else {
       //   Session::flash('error', 'There was a problem saving the updated user info to te database. Try again');
       //   return redirect()->route('users.edit', $id);
       // }

     }

    // public function update(Request $request, $id)
    // {
    //   $this->validate($request, [
    //     'first_name' => 'required|max:255',
    //     'last_name' => 'required|max:255',
    //     'email' => 'required|email|unique:users,email,'.$id
    //   ]);
    //
    //   $user = User::findOrFail($id);
    //   $user->first_name = $request->first_name;
    //   $user->last_name = $request->last_name;
    //   $user->email = $request->email;
    //   if ($request->password_options == 'auto') {
    //       $length = 10;
    //       $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //       $str = '';
    //       $max = mb_strlen($keyspace, '8bit') -1;
    //       for ($i = 0; $i < $length; ++$i) {
    //         $str .= $keyspace[random_int(0, $max)];
    //       }
    //       $user->password = Hash::make($str);
    //   } elseif ($request->password_options == 'manual') {
    //       $this->validate($request, [
    //         'password' => 'required|min:5|confirmed',
    //         'password_confirmation' => 'required|min:5'
    //       ]);
    //       $user->password = Hash::make($request->password);
    //   }
    //   $user->save();
    //
    //   if (empty($request->roles))
    //   {
    //     $user->detachRole($request->roles);
    //   } else {
    //     $user->syncRoles(explode(',', $request->roles));
    //   }
    //   // $user->syncRoles(explode(',', $request->roles));
    //   return redirect()->route('users.show', $id);
    //   // if () {
    //   //   return redirect()->route('users.show', $id);
    //   // } else {
    //   //   Session::flash('error', 'There was a problem saving the updated user info to te database. Try again');
    //   //   return redirect()->route('users.edit', $id);
    //   // }
    //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $address = Address::where('user_id', $id);
        $profile = Profile::where('user_id', $id);
        $user->delete();
        $address->delete();
        $profile->delete();

        Session::flash('success', 'Successfuly Deleted the account!');
        return redirect()->route('users.index');
    }

    // public function storeAssign(Request $request, $id)
    // {   
    //   $project = Project::findOrfail($id);
    //   $users = $project->users()->wherePivot('project_id', $id)->pluck('id')->toArray();
    //   dd($users);
    //   $users = $tasklist->users()->wherePivot('tasklist_id' , $id)->pluck('id')->toArray();
        
    // }

}
