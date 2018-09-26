@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager']) 
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Total Hours:</h2>
        <a href="{{route('attendance.index')}}">Attendance</a>
    </div>
</header>

<div class="row bg-white has-shadow mt-2">
    <div class="col-6">
            <a href="{{route('attendance.edit', $user->id)}}" class="bt btn-success btn-sm fa fa-pencil mb-2 mt-2" title="edit"> Edit</a>  
    </div>
    <div class="col-6">
        <form action="{{ route('attendance.show', $user->id) }}" method="post" class="attendance_delete">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-right mb-2 mt-2"></button>
        </form>
    </div>
</div>

<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
       <table class="table table-sm table-responsive mt-2">
           <thead>
               <th>Installer Name</th>
               <th>Project Name</th>
               <th>Travel Time</th>
               <th>Installation Hours</th>
               <th>Total</th>
           </thead>
           <tbody>
               <tr>
                   <td>{{$user->firstName}} {{$user->lastName}}</td>
                   <td>{{$user->projectName}}</td>
                   <td>
                        @foreach($projectHours as $hours)
                            {{$hours->travel_hours}}
                        @endforeach
                    </td>
                   <td>
                        @foreach($projectHours as $hours)
                            {{$hours->work_hours}}
                        @endforeach
                   </td>
                   <td>
                        {{$totalhours}}
                    </td>
               </tr>
               {{-- @endforeach --}}
           </tbody>
       </table>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6"></div>
    
</div>
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