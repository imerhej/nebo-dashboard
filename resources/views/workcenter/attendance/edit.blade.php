@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Edit Timesheet</h2>
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

    <!-- Success Message -->
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

    {{-- <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <a href="{{route('attendance.export')}}" class="btn btn-success btn-sm mt-2 mb-2">Export to Excel</a>
        </div>
    </div> --}}
<form action="{{route('attendance.edit', $attendance->id)}}" method="POST">
            {{csrf_field()}}
            {{method_field('PUT')}}
    <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-6 col-sm-6 col-md-6 mt-2">
                <label for="">Travel Time</label><br>
                <span class="text-muted">In</span>
                <input type="text" class="form-control" name="travelIn" value="{{$attendance->travelIn}}" id="travelIn" required>
                <span class="text-muted">Out</span>
                <input type="text" class="form-control" name="travelOut" value="{{$attendance->travelOut}}" id="travelOut" required>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 mt-2">
                <label for="">Installation Time</label><br>
                <span class="text-muted">In</span>
                <input type="text" class="form-control" name="installIn" value="{{$attendance->installIn}}" id="installIn" required>
                <span class="text-muted">Out</span>
                <input type="text" class="form-control" name="installOut" value="{{$attendance->installOut}}" id="installOut" required>
            </div>

            {{-- <div class="col-xs-3 col-sm-3 col-md-3 mt-2">
                <label for="">Over Time</label><br>
                <span class="text-muted">In</span>
                <input type="text" class="form-control" name="overtimeIn" value="{{$attendance->overtimeIn}}" id="overtimeIn">
                <span class="text-muted">Out</span>
                <input type="text" class="form-control" name="overtimeOut" value="{{$attendance->overtimeOut}}" id="overtimeOut">
            </div>

            <div class="col-xs-3 col-sm-3 col-md-3 mt-2">
                <label for="">Break Time</label><br>
                <span class="text-muted">In</span>
                <input type="text" class="form-control" name="breakIn" value="{{$attendance->breakIn}}" id="breakIn">
                <span class="text-muted">Out</span>
                <input type="text" class="form-control" name="breakOut" value="{{$attendance->breakOut}}" id="breakOut">
            </div> --}}

    </div><!--/.row -->
    <div class="row bg-white has-shadow">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <input type="submit" class="btn btn-primary btn-sm pull-right mb-2 ml-2" value="Update">
            <a href="{{route('attendance.index')}}" class="btn btn-secondary btn-sm pull-right mb-2">Close</a>
            
        </div>
    </div>
    </form>
</div><!--/.container-fluid -->
@endrole
@role(['installer', 'employee', 'manager', 'supervisor', 'client'])  
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script>
   
</script>
@endsection