@extends('layouts.workcenterlayout')

@section('content')
<div class="modal fade" id="leaveRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Request Time Off</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'myaccount.store')) !!}
                <input type="hidden" name="fullName" value="{{Auth::user()->firstName}} {{Auth::user()->lastName}}">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_time">Start Time:</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                
    
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end_time">End Time:</label>      
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="reason">Reason:</label>
                            <textarea class="form-control" name="reason" id="reason" placeholder=""></textarea>
                        </div>
                    </div>
                </div>
                    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div><!--/.modal -->
    <div class="container-fluid">
          <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="no-margin-bottom">My Account</h2>
            </div>
        </header>

        @foreach($errors->all() as $message)
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                {{ $message }}
            </div>
        @endforeach
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

        <div class="row bg-white has-shadow">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <strong>{{$user->firstName}} {{$user->lastName}} Details:</strong>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#leaveRequest" data-whatever="@mdo"> Request Time Off</button>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <a href="{{route('myaccount.edit', $user->id)}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i></a>
                            </div>
                        </div>
                            
                            
                    </div><!--/.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="field">
                                    <p class="h6">First Name: <span class="h6 text-muted">{{$user->firstName}}</span></p>
                                   </div>
                                 <div class="field">
                                    <p class="h6">Middle Name: <span class="h6 text-muted">{{$user->middleName}}</span></p>
                                </div>
                                 <div class="field">
                                    <p class="h6">Last Name: <span class="h6 text-muted">{{$user->lastName}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">E-mail: <span class="h6 text-muted">{{$user->email}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Phone Number: <span class="h6 text-muted">{{$user->address->phone_number}}</span></p>
                                </div>
                            </div><!--/.user-details -->
                            <div class="col-lg-4">
                                <div class="field">
                                    <p class="h6">Address 1: <span class="h6 text-muted">{{$user->address->address1}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Address 2: <span class="h6 text-muted">{{$user->address->address2}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">City: <span class="h6 text-muted">{{$user->address->city}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">State: <span class="h6 text-muted">{{$user->address->state}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Zipcode: <span class="h6 text-muted">{{$user->address->zipcode}}</span></p>
                                </div>
                            </div><!--/.user-address -->
                            <div class="col-lg-4">
                                <div class="field">
                                        <p class="h6">Pay Rate: <span class="h6 text-muted">{{$user->profile->payrate}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Status: <span class="h6 text-muted">{{$user->profile->status}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Employee Type: <span class="h6 text-muted">{{$user->profile->employeeType}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Hire Date: <span class="h6 text-muted">{{date('F j Y', strtotime($user->profile->hireDate))}}</span></p>
                                </div>
                                <div class="field">
                                    @foreach ($user->department as $department)
                                     <p class="h6">Department: <span class="h6 text-muted">{{$department->departmentTitle}}</span></p>
                                    @endforeach
                                </div>
                            </div><!--/.user-work-profile -->
                        </div>
                    </div><!--/.card-body -->
                </div><!--/.card-->
            </div><!--/.clo-lg-12 -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card mt-2">
                        {{-- <div class="card-header"> --}}
                            
                        {{-- </div><!--/.card-header --> --}}
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-lg-4 col-sm-4">
                                            <p class="h6">Current Projects/Tasks: {{$user->projects->count()}}</p>
                                            @foreach ($user->projects as $project)
                                                 <span class="h6 text-muted"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a></span><br>
                                            @endforeach
                                        </div>
                                        <div class="col-lg-4 col-sm-4">
                                            {{-- <p class="h6">Current Tasks: {{$user->tasklists->count()}}</p>
                                            @foreach ($tasklists as $tasklist)
                                                
                                                <span class="h6 text-muted">
                                                    <a href="{{route('projects.tasklists', $tasklist->project_id)}}">{{$tasklist->tasklistname}}</a>
                                                </span><br>
                                                
                                            @endforeach --}}
                                            <p class="h6">Leave Request:</p>
                                            @foreach ($user->leaves as $leave)
                                                <a href="{{route('myaccount.show', $leave->id)}}">
                                                    @if ($leave->status == 'pending')
                                                        <span class="badge badge-secondary">{{$leave->status}}</span>
                                                    @elseif ($leave->status == 'approved')
                                                        <span class="badge badge-primary">{{$leave->status}}</span>
                                                        @elseif ($leave->status == 'denied')
                                                        <span class="badge badge-danger">{{$leave->status}}</span>
                                                    @endif
                                                </a><br/>
                                            @endforeach
                                        </div>
                                        <div class="col-lg-4 col-sm-4">
                                            @foreach ($user->roles as $role)
                                                <p class="h6">Role: <span class="h6 text-muted">{{$role->display_name}}</span></p>
                                            @endforeach
                                        </div>
                            </div>
                        </div><!--/.card-body-->
                    </div><!--/.card-->
                </div><!--/.clo-lg-12 -->
        </div><!--/.row -->
        
    </div><!--/.container-fluid -->
@endsection