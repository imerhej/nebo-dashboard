@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
  <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Manage Employees</h2>
    </div>
</header>

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

<!-- Project Manager section -->
<section class="users no-padding-bottom">
    <div class="row bg-white has-shadow">
        <!-- Item -->
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="item d-flex align-items-center">
                <div class="title">
                    <a href="{{route('users.create')}}" class="btn btn-primary fa fa-plus-circle mb-2"> New Employee</a>
                  </div>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="item d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" name="search"
                            placeholder="Filter by role"> <span class="input-group-btn">
                        </span>
                    </div>
            </div>
        </div>
        {{-- <div class="col-xs-5 col-sm-5 col-md-5">
                <div class="item d-flex align-items-center">
                    <form action="{{route('users.index')}}" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text"  class="form-control" name="search"
                                placeholder="Search users"> <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div> --}}
    </div><!--/.row -->


<!-- All Users -->
<div class="row bg-white has-shadow">
  <div class="col-md-12 justify-content-md-center">
      <table class="table table-striped table-hover table-sm table-responsive" id="myTable">
          {{-- @if(isset($users)) --}}
          
        <thead>
          <th>Full Name</th>
          <th>E-mail</th>
          {{-- <th>Availablility</th> --}}
          <th>Employment Type</th>
          <th>Joined</th>
          <th>Role</th>
          <th>Activity</th>
          <th></th>
          {{-- <th>Performance</th> --}}
        </thead>
        <tbody>
          @foreach ($employees as $employee)
          <tr>
            <td>{{$employee->firstName}} {{$employee->lastName}}</td>
            <td>{{$employee->email}}</td>
            {{-- <td>
                @if($user->available == 'available')
                <span class="badge badge-success">available</span>
                @elseif($user->available == 'unavailable')
                <span class="badge badge-danger">unavailable</span>
                @endif
                @foreach ($user->department as $department)
                {{$department->departmentTitle}}
                @endforeach
            </td> --}}
            <td>{{$employee->profile->employeeType}}</td>
            <td>{{date('F j Y', strtotime($employee->profile->hireDate)) }}</td>
            <td>
                {{$employee->roles->count() == 0 ? 'No roles yet' : ''}}
                @foreach ($employee->roles as $role)
                  {{$role->display_name}}
                @endforeach
            </td>
            <td>
                @if ($employee->last_login_at < $employee->last_logout_at)
                    <i class="badge badge-danger">Offline</i>
                    @elseif ($employee->last_login_at > $employee->last_logout_at)
                    <i class="badge badge-success">Online</i>
                    @elseif ($employee->last_login_at == '')
                    <i class="badge badge-danger">Offline</i>
                @endif
            </td>
            <td>
            @role(['superadministrator', 'administrator', 'office-manager'])
              <a href="{{route('users.show', $employee->id)}}" class="btn btn-primary btn-sm fa fa-eye" title="View"></a>
              <a href="{{route('hrmanagement.performance', $employee->id)}}" class="btn btn-default btn-sm fa fa-list-alt" title="Performance Review"></a>
              <a href="{{route('hrmanagement.reports', $employee->id)}}" class="btn btn-secondary btn-sm fa fa-file-text" title="Daily Report"></a>
              @endrole
            </td>
            {{-- <td>
                @foreach ($performances as $performance)
                @if ($employee->id == $performance->user_id)
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{round((($performance->job_knowledge+
                        $performance->work_quality+
                        $performance->attendance_punctuality+
                        $performance->initiative+
                        $performance->comm_listening+
                        $performance->dependability)/30)*100)}}%">

                        {{round((($performance->job_knowledge+
                        $performance->work_quality+
                        $performance->attendance_punctuality+
                        $performance->initiative+
                        $performance->comm_listening+
                        $performance->dependability)/30)*100)}}%
                </div>
                @endif
                @endforeach
            </td> --}}
          </tr>
          @endforeach
          {{-- @endif --}}
        </tbody>
      </table>
      {{-- {{$users->links()}} --}}
  </div>
</div><!--/.row -->
</section>

</div><!--/.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script>
     function myFunction() {
        var input, filter, table, thead, th, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
       for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[4];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            } else {
            tr[i].style.display = "none";
            }
        }

        }
    }
        </script>
@endsection
