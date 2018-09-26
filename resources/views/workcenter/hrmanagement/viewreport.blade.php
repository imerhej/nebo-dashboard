@extends('layouts.workcenterlayout')

@section('content')
           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">{{$installer->firstName}} {{$installer->lastName}} - Report</h5>
            <a href="{{route('hrmanagement.reports', $report->installer_id)}}">Reports</a>
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
        <div class="col-12">
            <a href="{{route('hrmanagement.editreport', $report->id)}}" class="btn btn-success btn-sm fa fa-pencil mb-2 mt-2" title="Edit Report"> Edit</a>
        </div>
    </div>
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="card mt-2">
                <div class="card-body">
                    <label for="notes">Installer Name:</label>
                    <span class="text-muted">{{$installer->firstName}} {{$installer->lastName}}</span><br>

                    <label for="notes">Lead Installer/Supervisor:</label>
                    <span class="text-muted">{{$report->leadInstaller}}</span><br>

                    <label for="notes">Project:</label>
                    <span class="text-muted">{{$project->projectName}}</span><br>

                    <label for="notes">Scope Of Work:</label>
                    <span class="text-muted">{{$report->scope_work}}</span><br>

                    <label for="notes">Submitted At:</label>
                    <span class="text-muted">{{date('F j Y @ h:i:s a', strtotime($report->created_at))}}</span><br>

                    <label for="notes">Updated At:</label>
                    <span class="text-muted">{{date('F j Y @ h:i:s a', strtotime($report->updated_at))}}</span>
                
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="card mt-2">
                <div class="card-body">
                    <label for="notes">Report Notes:</label>
                    <span class="text-muted">{{$report->notes}}</span>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection