@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Edit - Request Time Off</h2>
    </div>
</header>
<div class="row bg-white has-shadow mt-2 justify-content-md-center">
    <div class="col-8">
            {!! Form::model($leave, ['route' => ['rto.update', $leave->id], 'method' => 'PUT']) !!}
        <div class="card">
            <div class="card-header">
                <h5 class="no-margin-bottom">Update request time off</h5>
            </div><!--/.card-header -->
            <div class="card-body">
                <div class="row">
                        <div class="col-12">
                            @foreach ($leave->users as $user)
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="text" value="{{$user->firstName}} {{$user->lastName}}"  class="form-control" disabled>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" value="{{$leave->start_date}}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start_time">Start Time:</label>
                                <input type="time" name="start_time" value="{{$leave->start_time}}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
        
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" value="{{$leave->end_date}}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_time">End Time:</label>      
                                <input type="time" name="end_time" value="{{$leave->end_time}}" class="form-control" required>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="reason">Reason:</label>
                                <textarea class="form-control" name="reason" id="reason" placeholder="">{{$leave->reason}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-8">
                                <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="Approve" name="status" value="approved" {{ ($leave->status == 'approved') ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="Approve">Approved</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="Denied" name="status" value="denied" {{ ($leave->status == 'denied') ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="Denied">Denied</label>
                                </div>  
                                <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="Pending" name="status" value="pending" {{ ($leave->status == 'pending') ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="Pending">Pending</label>
                                </div>  
                            </div>
                            <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right">Update Request</button>
                            </div>
                            
                        </div>
                        
                </div>
                
            </div><!--/.card-body -->
        </div><!--/.card -->
        {!! Form::close() !!}
            
        
    </div>
</div>
</div><!--/.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection