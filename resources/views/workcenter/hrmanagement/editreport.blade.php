@extends('layouts.workcenterlayout')

@section('content')
           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Edit Report</h5>
            <a href="{{route('hrmanagement.reports', $report->installer_id)}}">Reports</a>
        </div>
</header>
    <!-- Success Message-->
    @foreach($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        {{ $message }}
    </div>
    @endforeach
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-6 colsm-6 col-md-6">
        <form action="{{route('hrmanagement.editreport', $report->id)}}" method="POST">
                        {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="modal-body">
                <div class="form-group">
                    <label for="tco_date" class="col-form-label">Installer Name:</label>
                    <input type="text" name="" value="{{$installer->firstName}} {{$installer->lastName}}" class="form-control" id="" disabled>
                </div>
    
                <div class="form-group">
                    <label for="tco_date" class="col-form-label">Scope Of Work:</label>
                    <input type="text" name="scope_work" value="{{$report->scope_work}}" class="form-control" id="scope_work" required>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Notes:</label>
                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="10">{{$report->notes}}</textarea>
                </div>
                
            </div>
            <div class="modal-footer">
                <a href="{{route('hrmanagement.reports', $report->installer_id)}}" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</a>
                <input type="submit" class="btn btn-primary btn-sm" value="Submit">
            </div>
        
        </form>
           
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection