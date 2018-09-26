@extends('layouts.workcenterlayout')

@section('content')

<div class="container-fluid">
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
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
            
            @role(['superadministrator', 'administrator', 'manager', 'supervisor'])
            <h5 class="no-margin-bottom">Task List Name: {{$task->tasklistname}} </h5>
            <a href="{{route('projects.tasklists', $projectId )}}"><h5 class="no-margin-bottom">Task List: </h5></a>
            @endrole
            @role(['installer'])
            <a href="{{route('myaccount.mytasks', Auth::user()->id)}}"><h5 class="no-margin-bottom">Task List Name: {{$task->tasklistname}}</h5></a>
            @endrole

        </div>
    </header>
    @role(['installer'])
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-3 col-sm-3 col-md-3 mt-2 mb-2">
            @foreach ($user as $u)
            @if (Auth::user()->id === $u->user_id || $userPermission)
            <a href="{{route('projects.punchtaskhours', $projectId)}}" class="btn btn-primary btn-sm mb-2 mt-2">Clock In/Out</a>
            @endif
            @endforeach
            
        </div>
    </div>
    @endrole
    <div class="row bg-white has-shadow mt-2">
        <div class="col-6 mt-2">
            <p class="h6">Task Name: <span class="text-muted">{{$task->tasklistname}}</span></p>
            <p class="h6">Task Details: <span class="text-muted">{{$task->tasklistdetails}}</span></p>
            <p class="h6">Start Date: <span class="text-muted">{{date('F j Y', strtotime($task->start_date))}}</span></p>
            <p class="h6">End Date: <span class="text-muted">{{date('F j Y', strtotime($task->end_date))}}</span></p>
        </div>
        <div class="col-6 mt-2">
            <p class="h6">Project Name: <span class="text-muted">{{$project->projectName}}</span></p>
            <p class="h6">Client Name: <span class="text-muted">{{$project->projectDetail->clientName}}</span></p>
            <p class="h6">Address: <span class="text-muted">
                {{$project->projectDetail->address1}} {{$project->projectDetail->address2}}</p></span><span class="text-muted"> <p class="h6">
                {{$project->projectDetail->city}} {{$project->projectDetail->state}} {{$project->projectDetail->zipcode}}</span>
            </p>
        </div>
    </div><!--/.row -->
</div><!--/.container-fluid -->
{{-- @else
@include('workcenter.errors.404') --}}

@endsection