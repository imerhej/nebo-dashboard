@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Request time off Calendar</h2>
        </div>
    </header>
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-8 col-sm-8 col-md-8"> 
            <section class="section">
                    {!! $rto_details->calendar() !!}
            </section>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="card mt-1">
                <div class="card-body">
                    <label for="">Approved RTO:</label>
                    <div class="side-block mb-0">
                        @foreach ($leaves as $leave)
                            <span class="badge badge-primary">{{$leave->fullName}}</span>
                        @endforeach
                    </div>
                    
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-body">
                    <label for="">Pending RTO:</label>
                    <div class="side-block mb-0">
                        @foreach ($pending as $leave)
                            <span class="badge badge-secondary">{{$leave->fullName}}</span>
                        @endforeach
                    </div>
                    
                </div>
            </div>

            <div class="card mt-1">
                    <div class="card-body">
                        <label for="">Denied RTO:</label>
                        <div class="side-block mb-0">
                            @foreach ($denied as $leave)
                                <span class="badge badge-danger">{{$leave->fullName}}</span>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
        </div>
    </div><!--/.row -->
</div><!-- /.container-fluid -->
    {!! $rto_details->script() !!}
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection