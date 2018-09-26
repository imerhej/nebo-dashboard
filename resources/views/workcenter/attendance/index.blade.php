@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Attendance Timesheet</h5>
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

    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-6 col-sm-6 col-md-6">
        <a href="{{route('attendance.export')}}" class="btn btn-success btn-sm mt-2 mb-2">Export to Excel</a>
        </div>

        <form action="{{route('attendance.search')}}" method="POST" role="search">
                {{ csrf_field() }}
            <div class="row">
                  <div class="input-group mt-2 mb-2">
                    <input type="text" name="start" class="form-control mr-2" id="start" placeholder="Start Date">
                    <input type="text" name="end" class="form-control" id="end" placeholder="End Date">
                    <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-sm ">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                  </div>
                  <div class="col mt-2 mb-2">
                    
                  </div>
                  <div class="col mt-2 mb-2">
                        
                  </div>
            </div>
        </form>
    </div>

    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <table class="table-sm table-responsive table-bordered mb-2">
                <thead>
                    <th>Full Name</th>
                    <th>Project</th>
                    <th>Travel Date</th>
                    <th>Travel Time</th>
                    <th>Install Date</th>
                    <th>Install Time</th>
                    <th>Total Hours</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                    <tr>
                        <td>
                            {{$attendance->firstName}} {{$attendance->lastName}}
                        </td>
                       <td>
                            {{$attendance->projectName}}
                        </td>
                        <td>
                            {{date('F j Y', strtotime($attendance->travelIn))}} 
                        </td>
                        <td>
                            {{date('h:i:s a', strtotime($attendance->travelOut))}}
                        </td>
                        <td>
                            {{date('F j Y', strtotime($attendance->installIn))}} 
                        </td>
                        <td>
                            {{date('h:i:s a', strtotime($attendance->installOut))}}
                        </td>

                        <td>
                            @foreach ($projectHours as $hour)
                                @if ($attendance->id == $hour->id)                               
                                    {{round(($hour->travel_hours + $hour->work_hours)/ 3600, 2)}}                                             
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <a href="{{route('attendance.show', $attendance->id)}}" class="bt btn-primary btn-sm fa fa-eye" title="view"></a>   
                        </td>
                        <td>
                            <a href="{{route('attendance.edit', $attendance->id)}}" class="bt btn-success btn-sm fa fa-pencil" title="edit"></a>  
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!--/.container-fluid -->
@endrole
@role(['installer', 'employee', 'manager', 'supervisor', 'client'])  
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
      $(".attendance_delete").on("submit", function(){
         return confirm("Are you sure?");
      });

      $( "#start" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
   });
</script>
@endsection