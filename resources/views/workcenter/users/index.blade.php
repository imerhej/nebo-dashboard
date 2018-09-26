@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
  <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Manage Users</h2>
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
                    <a href="{{route('users.create')}}" class="btn btn-primary fa fa-plus-circle mb-2"> New User</a>
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
          @if(isset($users))
          
        <thead>
          <th>Full Name</th>
          <th>E-mail</th>
          {{-- <th>Availablility</th> --}}
          <th>Employment Type</th>
          <th>Joined</th>
          <th>Role</th>
          <th>Activity</th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
            <td>{{$user->firstName}} {{$user->lastName}}</td>
            <td>{{$user->email}}</td>
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
            <td>{{$user->profile->employeeType}}</td>
            <td>{{date('F j Y', strtotime($user->profile->hireDate)) }}</td>
            <td>
                {{$user->roles->count() == 0 ? 'No roles yet' : ''}}
                @foreach ($user->roles as $role)
                  {{$role->display_name}}
                @endforeach
            </td>
            <td>
                @if ($user->last_login_at < $user->last_logout_at)
                    <i class="badge badge-danger">Offline</i>
                    @elseif ($user->last_login_at > $user->last_logout_at)
                    <i class="badge badge-success">Online</i>
                    @elseif ($user->last_login_at == '')
                    <i class="badge badge-danger">Offline</i>
                @endif
            </td>
            <td>
              <a href="{{route('users.show', $user->id)}}" class="btn btn-primary btn-sm" title="view">
                <i class="fa fa-eye"></i> 
              </a>
              {{-- @role(['superadministrator']) --}}
              <a href="{{route('users.edit', $user->id)}}" class="btn btn-secondary btn-sm" title="edit"><i class="fa fa-pencil"></i> </a>
              {{-- <a href="{{route('users.edit', $user->id)}}" class="btn btn-default btn-sm" title="performance"><i class="fa fa-user"></i> </a> --}}
              {{-- @endrole --}}
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
      {{-- {{$users->links()}} --}}
  </div>
</div><!--/.row -->
</section>

</div><!--/.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor'])
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
