@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager', 'manager'])
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Performance Review - {{$performance->name}} </h5>
            <a href="{{route('hrmanagement.performance', $performance->user_id)}}">Performance list</a>
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
    <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <a href="{{route('hrmanagement.editperformance', $performance->id)}}" class="btn btn-primary btn-sm fa fa-pencil mb-2 mt-2 "> Edit Performance</a>
            </div>
    </div>

    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-body">
                    <label for="">Name: </label> <span class="text-muted">{{$performance->name}}</span><br>
                    <label for="">Job Title: </label> <span class="text-muted">{{$performance->jobTitle}}</span><br>
                    <label for="">Review Date: </label> <span class="text-muted">{{$performance->review_date}}</span><br>
                    <label for="">Department: </label> <span class="text-muted">{{$performance->department}}</span><br>
                    <label for="">Manager: </label> <span class="text-muted">{{$performance->manager}}</span><br>
                    <label for="">Review Period: </label> <span class="text-muted">{{$performance->review_period}}</span><br>
                </div>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-body">
                    <label for="" class="h6">Rating Comments: </label> <span class="text-muted">{{$performance->rating_comments}}</span><br>
                </div>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-body">
                        <label for="" class="h6">Additional Comments: </label> <span class="text-muted">{{$performance->additional_comments}}</span><br>
                </div>
            </div>
        </div>
    </div>

    <div class="row bg-white has-shadow">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-body">
                        <label for="" class="h6">Goals: </label> <span class="text-muted">{{$performance->goals}}</span><br>
                </div>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-body">
                        <div class="">
                        
                            <span class="text-muted">Job Knowledge :{{$performance->job_knowledge}}</span><br>
                            <span class="text-muted">Work Quality: {{$performance->work_quality}}</span><br>
                            <span class="text-muted">Attendance Punctuality:{{$performance->attendance_punctuality}}</span><br>
                            <span class="text-muted">Initiative:{{$performance->initiative}}</span><br>
                            <span class="text-muted">Communication/Listening skills:{{$performance->comm_listening}}</span><br>
                            <span class="text-muted">Dependability:{{$performance->dependability}}</span>
                        </div>

                        <label for="" class="h6">Average: </label> <br>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$average}}%">
                            {{round($average)}}%
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="card mt-2">
                        <div class="card-body">
                            <label for="">Employee Signature: </label> <span class="text-muted">{{$performance->employee_signature}}</span><br>
                            <label for="">Signature Date: </label> <span class="text-muted">{{$performance->employee_date}}</span><br>
                            <label for="">Manager Signature: </label> <span class="text-muted">{{$performance->manager_signature}}</span><br>
                            <label for="">Signature Date: </label> <span class="text-muted">{{$performance->manager_date}}</span><br>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div><!-- /.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection
