@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Attendance Timesheet</h5>
            <a href="{{route('attendance.index')}}">Attendance</a>
        </div>
    </header>
    @if(isset($punchhours))
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12">
             {{-- <a href="{{route('attendance.exportsearch')}}" class="btn btn-success btn-sm mt-2 mb-2">Export to Excel</a> --}}
             <form action="{{route('attendance.exportsearch')}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('GET')}}
             <input type="hidden" name="start" value="{{$start}}">
             <input type="hidden" name="end" value="{{$end}}">
             <button type="submit" class="btn btn-success btn-sm mt-2 mb-2" title="Export To Excel">Export to Excel</button>
            </form> 
        </div>
    </div>

{{-- @if(isset($punchhours)) --}}
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <table class="table-sm table-responsive table-bordered mb-2">
                <thead>
                    <th>Full Name</th>
                    <th>Project</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Total Hours</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($punchhours as $attendance)
                    <tr>
                        <td>
                            {{$attendance->firstName}} {{$attendance->lastName}}
                        </td>
                       <td>
                            {{$attendance->projectName}}
                        </td>
                        
                        <td>
                            {{$start}}
                        </td>

                        <td>
                            {{$end}}
                        </td>
                        <td>
                                {{round(($attendance->travel_hours + $attendance->work_hours) / 3600, 2)}}
                            </td>
                        <td>
                            <form action="{{route('attendance.totalHrs', $attendance->user_id)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('GET')}}
                            <input type="hidden" name="start" value="{{$start}}">
                            <input type="hidden" name="end" value="{{$end}}">
                            <button type="submit" class="btn btn-default btn-sm fa fa-clock-o" title="Total Time"></button>
                            </form>  
                        </td>
                        <td>
                            <form action="{{route('attendance.singleexport', $attendance->user_id)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('GET')}}
                            <input type="hidden" name="start" value="{{$start}}">
                            <input type="hidden" name="end" value="{{$end}}">
                            <button type="submit" class="btn btn-success btn-sm fa fa-file-excel-o" title="Export To Excel"></button>
                            </form>  
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
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