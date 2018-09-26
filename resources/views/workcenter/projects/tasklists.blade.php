@extends('layouts.workcenterlayout')

@section('content')

<div class="modal fade" id="clockInOut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form  action="{{route('projects.storeTaskHoursBySupervisor', $project->id)}}" method="POST">
                        {{ csrf_field() }}
            <input type="hidden" name="project_id" value="{{$project->id}}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Clock In/Out Installers</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="form-group">
                  <select name="user_id" id="" class="form-control" required>
                      <option value="">- Select Installer -</option>                      
                      @foreach ($users as $user)
                  <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                      @endforeach
        
                  </select>
                 
                </div>
                <div class="form-group">
                  <div class="row">
                        <div class="col-xs-36 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="travel" class="col-form-label">Travel Time:</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="travelIn" id="travelIn" value="travelIn">
                                        <label class="custom-control-label" for="travelIn">In</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="travelOut" id="travelOut" value="travelOut">
                                        <label class="custom-control-label" for="travelOut">Out</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="travel" class="col-form-label">Installation Time:</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="installIn" id="installIn" value="installIn">
                                        <label class="custom-control-label" for="installIn">In</label>
                                    </div>
                                </div>
                                    <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="installOut" id="installOut" value="installOut">
                                        <label class="custom-control-label" for="installOut">Out</label>
                                    </div>
                                    </div>
                            </div>
                  </div>
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm">Clock In/Out</button>
            </div>
          </div>
        </form>
        </div>
      </div><!-- Clock in Out -->

<div class="modal fade" id="taskList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Assign Task list</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form  action="{{route('projects.addTasklist', $project->id)}}" method="POST">
                        {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="tasklistname" class="form-control" placeholder="Task list name" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea name="tasklistdetails" class="form-control" placeholder="Task list details" rows="3"></textarea>
                        </div>      
                    </div>
                </div>
      
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="select-users" class="text-muted">- Select Employees -</label>
                            <select class="form-control select-multi"  name="users[]" multiple="multiple" style="width: 100%;" required>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}} - 
                                        @foreach ($user->roles as $role)
                                            {{$role->display_name}}
                                          @endforeach
                                    </option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" required>
                            </div>
                        </div>
                    </div>
                        
                    <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="milestone_id" id="" class="form-control" >
                                        <option value="">- Milestone -</option>
                                        @foreach($milestones as $milestone)
                                            <option value="{{$milestone->id}}">{{$milestone->milestoneName}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>       
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="color" id="color" class="form-control" required>
                                        <option value=""> - Select Color -</option>
                                        @foreach ($colors as $color)
                                        <option value="{{$color->value}}" style="{{$color->style}}">{{$color->name}}</option>
                                         @endforeach 
                                    </select>
                                </div>   
                            </div>
                        </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm">New Task list</button>
            </div>
            </form>
          </div>
        </div>
    </div><!--/.modal -->
    <div class="container-fluid">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h5 class="h4 no-margin-bottom"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> </h5> <span class="text-muted">Task Lists</span>
            </div>
        </header>
        <!-- Success Message -->
        <div class="row mt-2">
            <div class="container">
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
    <!-- Tasklist section -->
    @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'supervisor'])
    <section class="tasklists no-padding-bottom">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">
                        <button type="button" class="btn btn-primary btn-sm fa fa-plus-circle mb-2" data-toggle="modal" data-target="#taskList" data-whatever="@mdo"> New Tasklist</button>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-4 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">
                            <button type="button" class="btn btn-primary btn-sm fa fa-clock-o" data-toggle="modal" data-target="#clockInOut" data-whatever="@getbootstrap"> Clock In/Out</button>    
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-5 col-sm-6">
                
            </div>
        </div><!--/.row -->
    </section><!--/.Tasklist Section -->
    @endrole
    <section class="tasklist-details no-padding-botton">
        
        <div class="row bg-white has-shadow">
            <div class="col-lg-12">
                <table class="table table-sm table-responsive mt-2">
                    <thead>

                        <th>Task Name</th>
                        <th>Task Details</th>
                        <th>Status</th>
                        <th>Employee</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($tasklists as $tasklist)
                        {{-- @foreach ($tasklist->users as $user) --}}
                            @if (Auth::user()->id === $user->id || $userPermission)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                    value="{{$tasklist->id}}" 
                                   {{ ($tasklist->active == '0') ? 'checked' : ''}}
                                    class="custom-control-input" 
                                    id="{{$tasklist->id}}" disabled>
                                    <label class="custom-control-label" for="{{$tasklist->id}}">{!! $tasklist->tasklistname !!}</label>
                                </div>
                            </td>
                            
                            <td>
                                {!! str_limit($tasklist->tasklistdetails, 40) !!}
                            </td>
                            <td>
                                @if ($tasklist->active == '1')
                                <span class="active-project">Active</span>
                                @elseif ($tasklist->active == '0')
                                <span class="completed-project">Completed</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($tasklist->users as $user)
                                    {{$user->firstName}} {{$user->lastName}}
                                @endforeach
                            </td>
                            <td>{!! $tasklist->start_date!!}</td>
                            <td>{!! $tasklist->end_date!!}</td>
                            
                            <td>
                                <a href="{{route('projects.showTask', $tasklist->id)}}" title="View" class="btn btn-primary btn-sm fa fa-eye pull-right"></a>
                            </td>
                            
                            @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'supervisor'])
                            <td>
                                <form action="{{ route('projects.tasklists', $tasklist->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id" value="{{$tasklist->id}}">
                                    <button type="submit" class="btn btn-success btn-sm fa fa-check pull-right" title="Check Complete"></button>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('projects.tasklistfiles', $tasklist->id)}}" class="btn btn-secondary btn-sm fa fa-upload"></a>
                            </td>
                           
                            <td>
                                <a href="{{route('projects.editTasklist', $tasklist->id)}}" title="Edit" class="btn btn-primary btn-sm fa fa-edit pull-right"></a>
                            </td>
                            <td>
                                <form action="{{ route('projects.tasklists', $tasklist->id) }}" method="post" class="tasklist_delete">   
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-right" title="Delete"></button>
                                </form>
                            </td>
                            @endrole
                        </tr>
                        @endif
                        {{-- @endforeach --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section><!--/.tasklist-details section -->
</div><!--/.container-fluid -->
@endsection

@section('scripts')
<script>
    // var app = new Vue({
    //     el: '#app',
    //     data: {
    //         selectedTasks: []
    //     }
    // });
    $(document).ready(function(){
    $(".tasklist_delete").on("submit", function(){
    return confirm("Are you sure?");
    });
    $(".taskfile_delete").on("submit", function(){
    return confirm("Are you sure?");
    });
    $('.select-multi').select2();
    $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
 });
</script>
@endsection
