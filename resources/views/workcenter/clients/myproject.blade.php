@extends('layouts.workcenterlayout')

@section('content')
@if (Auth::user()->id == $client->id)
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">My Projects</h2>
        </div>
    </header>
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
    
    <div class="row bg-white has-shadow ">
        @foreach($projects as $project)
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <a href="{{route('clients.viewmyproject', $project->project_id)}}" class="project-link">
                    <div class="card-header project-name">
                        {!! $project->projectName !!}
                        <i class="fa fa-cog float-right"></i>
                    </div><!--/.card-header -->
                </a>
                <div class="card-body">
                        <label for="start_date">Project Details:</label>
                        <span class="text-muted">{!! str_limit($project->description, 60) !!}</span><br>

                    <label for="start_date">Start Date:</label>
                    <span class="text-muted">{{date('F j Y', strtotime($project->start_date))}}</span><br>

                    <label for="start_date">End Date:</label>
                    <span class="text-muted">{{date('F j Y', strtotime($project->end_date))}}</span>
                </div><!--/.card-body -->
            </div><!--/.card -->
        </div>
        @endforeach
    </div>
    

        
</div><!--/.container-fluid -->
@elseif (Auth::user()->id != $client->id)
@include('workcenter.errors.404')
@endif

@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".project_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection