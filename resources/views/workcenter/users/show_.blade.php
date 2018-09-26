@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
  <!-- Page Header-->
  <header class="page-header">
      <div class="container-fluid">
          <h2 class="no-margin-bottom">Manage Account</h2>
      </div>
  </header>

   <!-- Success Message -->
<div class="row mt-2">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>  
 
<div class="row bg-white has-shadow mt-2">
      <div class="col-lg-12">
        <div class="row mt-2">
          <div class="col-lg-4">
              <div class="card">
              <div class="card-header">
                
                {{-- @role(['superadministrator', 'administrator'])
                <a href="{{route('users.edit', $user->id)}}" class="pull-right"><i class="fa fa-edit"></i></a>
                @endrole --}}
                <strong>{{$user->firstName}} Details</strong>
                @role(['superadministrator', 'administrator'])
                @if (Auth::user()->id != $user->id)
                <div class="field">
                    
                    <form action="{{ route('users.destroy', $user->id) }}" method="post" class="user_delete">
                        
                      
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-right"></button>
                          <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary btn-sm fa fa-edit pull-right"></a>
                      </form>

                  {{-- {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'class' => 'delete']) !!}
                  {!! Form::submit('', ['class' => 'fa fa-trash-o']) !!}
                  {!! Form::close() !!} --}}
                </div>
                @endif
                @endrole
              </div>
              <div class="card-body">
                   
                  <div class="field">
                    <label for="firstName">First Name:</label>
                    <h5>{{$user->firstName}}</h5>
                  </div>
    
                  <div class="field">
                    <label for="middleName">Middle Name:</label>
                    <h5>{{$user->middleName}}</h5>
                  </div>
      
                  <div class="field">
                    <label for="firstName">Last Name:</label>
                    <h5>{{$user->lastName}}</h5>
                  </div>
      
                  <div class="field">
                    <label for="email">Email:</label>
                    <h5>{{$user->email}}</h5>
                  </div>

                  <div class="field">
                    <label for="phone_number">Phone Number:</label>
                    <h5>{{$user->address->phone_number}}</h5>
                  </div>
            </div>
          </div>
        </div>

        <!-- User Address -->
       
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header">
                  <strong> Address</strong>
              </div>
              <div class="card-body">
                  <div class="field">
                      <label for="address1">Address 1:</label>
                      <h5>{{$user->address->address1}}</h5>
                    </div>
        
                    <div class="field">
                      <label for="address2">Address 2:</label>
                      <h5>{{$user->address->address2}}</h5>
                    </div>
        
                    <div class="field">
                      <label for="city">City:</label>
                      <h5>{{$user->address->city}}</h5>
                    </div>
        
                    <div class="field">
                      <label for="state">State:</label>
                      <h5>{{$user->address->state}}</h5>
                    </div>
        
                    <div class="field">
                      <label for="zipcode">Zip Code:</label>
                      <h5>{{$user->address->zipcode}}</h5>
                    </div>
              </div>
            </div>             
          </div><!--/. user-address -->

          <!-- User Profile -->
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <strong>Work Profile</strong>
            </div>
            <div class="card-body">
              <div class="field">
                <label for="status">Employee Status:</label>
                <h5>{{$user->profile->status}}</h5>
              </div>

              <div class="field">
                  <label for="employeeType">Employee Type:</label>
                  <h5>{{$user->profile->employeeType}}</h5>
                </div>

              <div class="field">
                <label for="department">Department:</label>
                @foreach ($user->department as $department)
                <h5>{{$department->departmentTitle}}</h5>
                @endforeach
              </div>
    
                <div class="field">
                  <label for="hireDate">Hire Date:</label>
                  <h5>{{date('F j Y', strtotime($user->profile->hireDate))}}</h5>     
                </div>
            </div><!--/.card-body -->
            <div class="card-footer">
                
            </div>
          </div><!--/.card -->
        </div><!--/. user-profile -->
        
      </div><!--/.row -->
  
      <!-- Activity Log Column -->
      {{-- <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <strong>Activity Log</strong>
          </div>
          <div class="card-body">
              <div class="field">
                <label for="activity">Current Status:</label>
                  @if ($user->current_login < $user->last_logout)
                        <p class="btn btn-danger btn-xs">Offline</p>
                        @elseif ($user->current_login > $user->last_logout)
                        <p class="btn btn-success btn-xs">Online</p>
                        @elseif ($user->current_login == '')
                        <p class="btn btn-danger btn-xs">Offline</p>
                    @endif
                    @if ($user->current_login < $user->last_logout)
                     <pre>{{\Carbon\Carbon::parse($user->last_logout)->diffForHumans()}}</pre>
                     @elseif ($user->current_login > $user->last_logout)
                     <pre>{{\Carbon\Carbon::parse($user->current_login)->diffForHumans()}}</pre>
                    @endif
              </div>
              <div class="field">
                <label for="current_logint">Login Time:</label>
                @if ($user->current_login == '')
                  <pre>Never logged in</pre>
                  @elseif ($user->current_login != '')
                  <pre>{{date('F j Y @ h:i:s a', strtotime($user->current_login))}}</pre>
                @endif
              </div>
  
              <div class="field">
                <label for="last_logout">Last Logout Time:</label>
                @if ($user->last_logout == '')
                  <pre>Never logged out</pre>
                  @elseif ($user->last_logout != '')
                  <pre>{{date('F j Y @ h:i:s a', strtotime($user->last_logout))}}</pre>
                @endif
              </div>
  
              <div class="field">
                <label for="last_logout">Created At:</label>
                  <pre>{{date('F j Y @ h:i:s a', strtotime($user->created_at))}}</pre>
              </div>
  
              <div class="field">
                <label for="last_logout">Last Update:</label>
                  <pre>{{date('F j Y @ h:i:s a', strtotime($user->updated_at))}}</pre>
              </div> 
  
              
          </div>
        </div>
      </div>--}}
       
     </div><!--/.col-lg-12 -->
    </div><!--/. row bg-white -->
    <!-- User Roles -->
    <div class="row bg-white has-shadow"> 
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <strong>Roles</strong>
            </div>
            <div class="card-body">
                <div class="field">
                      <p>
                      {{$user->roles->count() == 0 ? 'This user has not been assigned any roles yet' : ''}}
                      @foreach ($user->roles as $role)
                        <p>{{$role->display_name}} ({{$role->description}})</p>
                      @endforeach
                      </p>
                    </div>
        
                    {{-- <div class="field">
                      <p>
                      {{$user->permissions->count() == 0 ? 'This user has not been assigned any permission yet' : ''}}
                      @foreach ($user->permissions as $permission)
                        <p>{{$permission->display_name}} ({{$permission->description}})</p>
                      @endforeach
                      </p>
                    </div> --}}
            </div><!--/.card-body -->
          </div><!--/.card -->
        </div><!--/.col -->
      </div><!--/. row -->
  </div><!--/.container-fluid -->
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".user_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection