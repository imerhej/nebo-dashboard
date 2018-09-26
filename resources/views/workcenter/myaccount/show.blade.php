@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
 <!-- Page Header-->
 <header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">My Leave</h2>
    </div>
</header>
@if(Auth::user()->id == $leave->user_id)
<div class="row bg-white has-shadow mt-2 justify-content-md-center">
    <div class="col-xs-6 col-sm-6 col-md-6 mt-2">
        <div class="card">
            <div class="card-header">
                <p class=" h5 text-sm-left">Request Date: </p>{{date('F j Y @ h:i:s a', strtotime($leave->created_at))}}
            </div><!--/.card-header -->
            <div class="card-body">
                <p class="text-sm-left">Start Date: {{date('F j Y', strtotime($leave->start_date))}}</p>
                <p class="text-sm-left">Start Time: {{date('g:i a', strtotime($leave->start_time))}} </p>
                <p class="text-sm-left">End Date:{{date('F j Y', strtotime($leave->end_date))}}</p>
                <p class="text-sm-left">End Time: {{date('g:i a', strtotime($leave->end_time))}}</p>
                <p class="text-sm-left">Reason: {{$leave->reason}}</p>
                <p class="text-sm-left">Status: 
                    @if ($leave->status == 'pending')
                        <span class="badge badge-secondary">{{$leave->status}}</span>
                    @elseif ($leave->status == 'approved')
                        <span class="badge badge-primary">{{$leave->status}}</span>
                        @elseif ($leave->status == 'denied')
                        <span class="badge badge-danger">{{$leave->status}}</span>
                    @endif
                </p>
            </div><!--/.card-body -->
        </div><!--/.card -->
    </div>
</div><!--/.row -->
@else
@include('workcenter.errors.404')
@endif
</div><!--/.container-fluid -->
@endsection