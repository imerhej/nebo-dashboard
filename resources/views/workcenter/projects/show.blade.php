@extends('layouts.workcenterlayout')

@section('content')

<div class="modal fade" id="generate-report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('hrmanagement.reports', $project->id)}}" method="POST">
                    {{csrf_field()}}
        @foreach ($project->users as $user)
            <input type="hidden" name="leadInstaller" value="{{$user->firstName}} {{$user->lastName}}">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <input type="hidden" name="supervisorEmail" value="{{$user->email}}">
        @endforeach
        
        <input type="hidden" name="project_id" value="{{$project->id}}">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Generate Report</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="tco_date" class="col-form-label">Installer Name:</label>
                <select name="installer_id" id="installerName" required class="form-control">
                    <option value="">- Select Installer -</option>
                    @foreach($installers as $installer)
                        <option value="{{$installer->id}}">{{$installer->firstName}} {{$installer->lastName}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tco_date" class="col-form-label">Scope Of Work:</label>
                <input type="text" name="scope_work" class="form-control" id="scope_work" required>
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">Notes:</label>
                <textarea  name="notes" class="form-control" id="notes"></textarea>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
        </div>
    
        </div>
    </form>
    </div>
</div> 

<div class="modal fade" id="tco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('projects.tco', $project->id)}}" method="POST">
                    {{csrf_field()}}
        
        <input type="hidden" name="project_id" value="{{$project->id}}">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Schedule TCO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label for="tco_date" class="col-form-label">Date:</label>
                <input type="text" name="tco_date" class="form-control" id="tco_date" required>
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">Notes:</label>
                <textarea  name="notes" class="form-control" id="notes"></textarea>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
        </div>
    
        </div>
    </form>
    </div>
</div> 
<!-- TCO Modal -->

<div class="modal fade" id="changeOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
                
        <form action="{{route('projects.show', $project->id)}}" method="POST" class="form">
                        {{csrf_field()}}
            @foreach ($project->users as $user)
            <input type="hidden" name="leadInstaller" value="{{$user->firstName}} {{$user->lastName}}">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <input type="hidden" name="supervisorEmail" value="{{$user->email}}">
            @endforeach
            <input type="hidden" name="subject" value="Change Order">
            <input type="hidden" name="project_id" value="{{$project->id}}">
            @foreach ($client as $cleinty)
            
            <input type="hidden" name="client_id" id="client_id" value="{{$cleinty->id}}">
            <input type="hidden" name="clientName" value="{{$project->projectDetail->clientName}}">
            <input type="hidden" name="clientEmail" value="{{$cleinty->email}}">
            @endforeach
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change Order Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Client Name:</label>
                            <input type="text" name="clientName" value="{{ $project->projectDetail->clientName }}" class="form-control" id="clientName" disabled>
                        </div>             
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            @foreach ($project->users as $user)
                            <label for="recipient-name" class="col-form-label">Lead Installer Name:</label>
                            <input type="text" name="leadInstaller" value="{{$user->firstName}} {{$user->lastName}}" class="form-control" id="leadInstaller" disabled>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Change Order Details:</label>
                            <textarea name="order_details" class="form-control" id="order-details" required></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Client Signature:</label>
                            <input type="text" name="client_signature" class="form-control" id="client_signature" placeholder="Print Your Name" disabled>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Lead Installer Signature:</label>
                            <input type="text" name="leadinstaller_signature" class="form-control" id="leadinstaller_signature" placeholder="Print Your Name" required>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary btn-sm" value="Send Request">
            </div>
          </div>
        </form>
        </div>
      </div>  <!-- Change Order -->         
<div class="container-fluid">
        @foreach($errors->all() as $message)
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
        @endforeach
    <!-- Success Message-->
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
                {{-- @foreach ($project->users as $user) --}}
                {{-- @if (Auth::user()->id === $user->id || $userPermission) --}}
                <div class="col-sm-6">
                    <p class="h6 text-muted mt-3">Project Name: {!! $project->projectName !!}</p>
                    
                    {{-- <p class="h5 mt-3">Project Supervisor: <span class="text-muted">{{$user->firstName}} {{$user->lastName}} | {{$user->address->phone_number}}  </span></p> --}}
                {{-- @endif  
                @if (Auth::user()->id === $user->id || $userPermission) --}}
                    <p class="h6 text-muted ">On Site Contact Name:  {!! $project->projectDetail->clientName !!} | {!! $project->projectDetail->phone_number !!}</p>
                    <p class="h6 text-muted "> Description: {!! $project->description !!}</p>
                </div>
                {{-- @endif --}}
                {{-- @endforeach --}}
                @if (Auth::user()->id === $user->id || $userPermission)
                <div class="col-sm-3">
                    
                    <p class="h4 mt-3">
                        Task Progress: 
                        @foreach($active as $activeTask)
                        @if ($activeTask->activeTasks <= $project->tasklist->count() )
                        <span class="active-project"> Active</span>
                        @endif
                        @endforeach
                        @foreach ($completed as $completedTask)
                        @if ($completedTask->completedTasks == $project->tasklist->count())
                        <span class="completed-project"> Completed</span>
                        @endif
                        @endforeach
                    </p>
                    
                    <div class="progress mb-2">
                        @foreach ($completed as $completedTask)
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{($completedTask->completedTasks / $project->tasklist->count() * 100 )}}%">
                            {{round($completedTask->completedTasks / $project->tasklist->count() * 100 )}}%
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @role(['superadministrator', 'administrator', 'office-manager', 'manager'])
                <div class="col-sm-3">
                    <form action="{{ route('projects.destroy', $project->id) }}" method="post" class="project_delete">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o mt-4 pull-right"></button>
                        <a href="{{route('projects.edit', $project->id)}}" class="btn btn-primary btn-sm fa fa-pencil mt-4 pull-right"></a>
                     </form>
                </div>
                @endrole
            </div>
            
            
            <!-- Buttons -->
            
            <div class="row bg-white has-shadow mt-2">
                @if (Auth::user()->id === $user->id || $userPermission)
                @role(['superadministrator', 'administrator', 'office-manager', 'manager', 'supervisor'])
                    
                <div class="col-xs-3 col-sm-3 col-md-3 mt-2 mb-2">
                    <button type="button" class="btn btn-primary btn-sm  mb-2 mt-2" data-toggle="modal" data-target="#tco" data-whatever="@getbootstrap">TCO Deadline</button>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 mt-2 mb-2">
                    <a href="{{route('projects.projectbudget', $project->id)}}" class="btn btn-primary btn-sm mb-2 mt-2">Rates & Budget</a>
                </div>
                
                <div class="col-xs-3 col-sm-3 col-md-3 mt-2 mb-2">
                    <button type="button" class="btn btn-primary btn-sm  mb-2 mt-2" data-toggle="modal" data-target="#changeOrder" data-whatever="@getbootstrap" id="changeorder">Change Order</button>
                </div>

                <div class="col-xs-3 col-sm-3 col-md-3 mt-2 mb-2">
                    <button type="button" class="btn btn-primary btn-sm  mb-2 mt-2" data-toggle="modal" data-target="#generate-report" data-whatever="@getbootstrap">Generate Report</button>
                </div>
                @endrole
                @endif
            </div>
            
            @if (Auth::user()->id === $user->id || $userPermission)
            <div class="row links bg-white has-shadow">
                <div class="col-sm-2">
                    <div class="title text-center"> 
                    <a href="{{route('projects.show', $project->id)}}" class="padding-top mb-2">
                            <i class="icon-screen"></i> 
                            Overview
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="title text-center">
                        <a href="{{route('projects.discussions', ['project_id' => $project->id])}}" class="padding-top mb-2">
                            <i class="icon-mail"></i> 
                             Discussions {{$project->discussions->count()}}
                        </a>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="title text-center">
                        <a href="{{route('projects.tasklists', ['project_id' => $project->id])}}" class="padding-top mb-2">
                            <i class="icon-list"></i> 
                            Task Lists {{$project->tasklist->count()}}
                        </a>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="title text-center">
                        <a href="{{route('projects.milestones', ['project_id' => $project->id])}}" class="padding-top mb-2">
                            <i class="icon-clock"></i> 
                            Milestones {{$project->milestone->count()}}
                        </a>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="title text-center">
                    <a href="{{route('projects.files', ['project_id' => $project->id])}}" class="padding-top mb-2">
                            <i class="fa fa-file"></i> 
                            Files {{$project->files->count()}}
                        </a>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="title text-center">
                        <a href="{{route('projects.changeOrders', ['project_id' => $project->id])}}" class="padding-top mb-2">
                            <i class="fa fa-file"></i> 
                            Change Orders 
                            {{-- {{$project->files->count()}} --}}
                        </a>
                    </div>
                </div>
            </div>
            
            @endif

            @if (Auth::user()->id === $user->id || $userPermission)
            <div class="row bg-white has-shadow mt-2">
                <div class="col-lg-12 mt-2 mb-2">
                <h6 class="text-muted">Due date: {{date('F j Y', strtotime($project->end_date))}}
            </h6>
                    <div class="progress">
                        <div id="progressbar"  role="progressbar"  aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            
           
            
            <div class="row bg-white has-shadow mt-2">
                    <!-- calendar -->
                    <div class="col-xs-9 col-sm-9 col-md-9 mt-2">
                        {!! $projectEvent->calendar() !!}
                        {{-- {!! $milestoneEvent->calendar() !!} --}}
                        {!! $tasklistEvent->calendar() !!}
    
                        {!! $projectEvent->script() !!}
                        {{-- {!! $milestoneEvent->script() !!} --}}
                        {!! $tasklistEvent->script() !!}
                    </div><!--/.col-lg-8 -->
    
                    <!-- Blocks -->
                    <div class="col-lg-3 mt-2">
                        <div class="card mt-1">
                            <div class="card-body">
                                <label for="">Supervisor:</label>
                                <div class="side-block mb-0">
                                    @foreach ($project->users as $user)
                                        <span class="badge badge-secondary">{{$user->firstName}} {{$user->lastName}} - {{$user->address->phone_number}}</span>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>

                        <div class="card mt-1">
                                <div class="card-body">
                                    <label for="">Deadline for TCO:</label>
                                    <div class="side-block">
                                    @foreach ($tcos as $tco)
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            {{date('F j Y', strtotime($tco->tco_date))}} 
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <form action="{{ route('projects.tco', $tco->id) }}" method="post" class="tco_delete">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o mt-1 pull-right" title="delete"></button>
                                            </form>
                                        </div>
                                    </div>
                                                                              
                                    @endforeach
                                    </div>
                                </div>
                            </div>
    
                        <div class="card mt-1">
                            <div class="card-body">
                                <label for="">Tasklists:</label>
                                <div class="side-block">
                                @foreach ($project->tasklist as $tasklist)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{$tasklist->id}}" {{ ($tasklist->active == '0') ? 'checked' : ''}} disabled >
                                    <label class="custom-control-label" for="{{$tasklist->id}}">
                                    <a href="{{route('projects.tasklists', $project->id)}}">{{$tasklist->tasklistname}}</a></label>
                                </div>
                                    
                                @endforeach
                                </div>
                            </div>
                        </div>
    
                        <div class="card mt-1">
                            <div class="card-body">
                                <label for="">Category:</label>
                                <div class="side-block">
                                {{-- @foreach ($project->category as $category) --}}
                                    <span>{{$project->categoryName}}</span>
                                {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>
    
                        <div class="card mt-1">
                            <div class="card-body">
                                <label for="">Department:</label>
                                <div class="side-block">
                                {{-- @foreach ($project->department as $department) --}}
                                    <span>{{$project->departmentTitle}}</span>
                                {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>
    
                    </div><!--/.col-lg-4 -->
                </div><!--/.row -->
                @endif
                
</div><!--/.content-inner -->

@endsection
@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
  <script>
    CKEDITOR.env.isCompatible = true;
    CKEDITOR.replace( 'order-details' );
    $(document).ready(function(){
      $(".project_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
      $(".tco_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
      $( "#tco_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    // Disable changeorder button
    var b = $('.form').has('#client_id').length ? "yes" : "no";
    // var id = $('#client_id').val();
    if ( b == 'yes') {
        $('#changeorder').removeAttr('disabled')
    } else if ( b == 'no') {
        $('#changeorder').attr('disabled', 'disabled')
    }
    

    // Progress Bar for project
    if ( {{$percentUsed}} < 59 )
    {
        var green = Math.round({{$percentUsed}})
        $('#progressbar').addClass('progress-bar bg-success').html(green + '%').css('width', green + '%');
    } 
    else if ( {{$percentUsed}} >= 60 && {{$percentUsed}} < 80 )
    {
        var yellow = Math.round({{$percentUsed}});
        $('#progressbar').addClass('progress-bar bg-warning').html(yellow + '%').css('width', yellow + '%');
    }
    else if ( {{$percentUsed}} >= 80 && {{$percentUsed}} < 100 )
    {
        var red = Math.round({{$percentUsed}});
        $('#progressbar').addClass('progress-bar bg-danger').html(red  + '%').css('width', red  + '%');
    }  
    else if ( {{$percentUsed}} == 100 )
    {
        var newred = '100%';
        $('#progressbar').addClass('progress-bar bg-danger').html(newred).css('width', newred);
    } 
    else if ( {{$percentUsed}} > 100 )
    {
        var newred = '100%';
        $('#progressbar').addClass('progress-bar bg-danger').html(newred).css('width', newred);
    }

   });
  </script>
@endsection
