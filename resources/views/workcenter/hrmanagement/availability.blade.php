@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager']) 
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
            <h2 class="no-margin-bottom">Employee Availability </h2>
        </div>
    </header>
<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <table class="table table-sm table-responsive mt-2">
            <thead>
                <th>Full Name</th>
                <th>Status</th>
                <th>Role</th>
                <th>Current Projects</th>
                <th>Current Tasks</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td><a href="{{route('users.show', $user->id)}}">{{$user->firstName}} {{$user->lastName}}</a></td>
                    <td>
                        @foreach ($user->tasklists as $task)
                            @if ($user->id == $task->pivot->user_id)
                            <span class="badge badge-danger">Unavailable</span><br>
                            @else
                            <span class="badge badge-success">{{$user->availability}}</span>
                            @endif
                        @endforeach
                        
                        @foreach ($user->projects as $project)
                            @if ($user->id == $project->pivot->user_id)
                            <span class="badge badge-danger">Unavailable</span>
                            @else
                            <span class="badge badge-success" id="available"></span>
                            @endif
                        @endforeach

                    </td>
                    <td>
                        @foreach ($user->roles as $role)
                            {{$role->display_name}}
                        @endforeach
                    </td>
                    <td>
                        @foreach($user->projects as $project)
                        <a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> <br>
                        @endforeach
                    </td>
                    <td>      
                        @foreach ($user->tasklists as $task)
                            <a href="{{route('projects.showTask', $task->id)}}">{{$task->tasklistname}}</a> | <br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="col-xs-6 col-sm-6 col-md-6"></div> --}}
</div>
</div><!--/.container-fluid -->
@endrole
@role(['installer', 'employee', 'manager', 'supervisor', 'client'])  
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script>
    $('document').ready(function(){

    var t = $('td').html();
     if (t == null) {
         
         $('#available').append('Available');
     }
    });
</script>
@endsection
