@extends('layouts.workcenterlayout')

@section('content')
           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Scheduled Equipment</h2>
            <a href="{{route('projects.projectbudget', $project->id)}}">{{$project->projectName}}</a>
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
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <span class="text-muted h5" for="name">Project Name:</span> {{$project->projectName}} <br>
            <span class="text-muted h5" for="name">Equipment Name:</span> {{$inventory->name}} <br>
            <span class="text-muted h5" for="name">Quantity:</span> {{$equipment->quantity}} <br>
            <span class="text-muted h5" for="name">Start Date:</span> {{date('F j Y', strtotime($equipment->start_date))}}<br>
            <span class="text-muted h5" for="name">End Date:</span> {{date('F j Y', strtotime($equipment->end_date))}}<br>
            <span class="text-muted h5" for="name">Notes:</span> {{$equipment->notes}}<br>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection