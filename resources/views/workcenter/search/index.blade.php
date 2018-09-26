@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
  <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Search Results</h2>
        </div>
    </header>
    @if(!isset($projects))
    <div class="row bg-white has-shadow mt-2">
        <h5 class="text-muted mt-3 mb-3 ml-3">{{$message}}</h5>
    </div>
    @endif
    @if(isset($projects))
    <div class="row bg-white has-shadow mt-2">
        <div class="col-12 mt-2">           
            
                <p> The Search results for <b> {{ $query }} </b> are :</p>
            <table class="table table-sm table-responsive">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>{{$project->projectName}}</td>
                        <td>{{str_limit($project->description, 100)}}</td>
                        <td>
                            @if ($project->active == '1')
                            <span class="active-project">Active</span>
                            @elseif ($project->active == '0')
                            <span class="completed-project">Completed</span>
                            @endif
                        </td>
                        <td>{{ date('F j Y', strtotime($project->start_date)) }}</td>
                        <td>{{ date('F j Y', strtotime($project->end_date)) }}</td>
                        <td><a href="{{route('projects.show', $project->id)}}" class="btn btn-primary btn-sm fa fa-eye"></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
    @endif
    {{-- @if(isset($users))
    <div class="row bg-white has-shadow mt-2">
            <div class="col-12 mt-2">
                
                <p> The Search results for <b> {{ $query }} </b> are :</p>
                <table class="table table-sm table-responsive">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>E-mail</th>
                            <th>Department</th>
                            <th>Employment Type</th>
                            <th>Joined</th>
                            <th>Role</th>
                            <th>Activity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($users as $user)
                            <tr>
                              <td>{{$user->firstName}} {{$user->lastName}}</td>
                              <td>{{$user->email}}</td>
                              <td>
                                  @foreach ($user->department as $department)
                                  {{$department->departmentTitle}}
                                  @endforeach
                              </td>
                              <td>{{$user->profile->employeeType}}</td>
                              <td>{{date('F j Y', strtotime($user->profile->hireDate)) }}</td>
                              <td>
                                  {{$user->roles->count() == 0 ? 'No roles yet' : ''}}
                                  @foreach ($user->roles as $role)
                                    {{$role->display_name}}
                                  @endforeach
                              </td>
                              <td>
                                @if ($user->current_login < $user->last_logout)
                                      <i class="btn btn-danger btn-sm">Offline</i>
                                      @elseif ($user->current_login > $user->last_logout)
                                      <p class="btn btn-success btn-sm"></p>
                                      @elseif ($user->current_login == '')
                                      <i class="btn btn-danger btn-sm">Offline</i>
                                  @endif
                              </td>
                              <td>
                                <a href="{{route('users.show', $user->id)}}" class="btn btn-primary btn-sm">
                                  <i class="fa fa-eye"></i> 
                                </a>
                                @role(['superadministrator', 'administrator'])
                                <a href="{{route('users.edit', $user->id)}}" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i> </a>
                                @endrole
                              </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
        @endif --}}
</div><!--/.container-fluid -->

@endsection
@section('scripts')
<script>       

</script>
@endsection
