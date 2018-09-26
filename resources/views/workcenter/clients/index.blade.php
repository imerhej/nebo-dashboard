@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
  <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Manage Clients</h2>
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
                    <a href="{{route('clients.create')}}" class="btn btn-primary fa fa-plus-circle mb-2"> New Client</a>
                  </div>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="item d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" name="search"
                            placeholder="Filter by name"> <span class="input-group-btn">
                        </span>
                    </div>
            </div>
        </div>
    </div><!--/.row -->

<!-- All Users -->
<div class="row bg-white has-shadow">
  <div class="col-xs-12 col-sm-12 col-md-12 justify-content-md-center">
      <table class="table table-striped table-hover table-sm table-responsive" id="myTable">
         
        <thead>
          <th>Company Name</th>
          <th>Contact Name</th>
          <th>E-mail</th>
          <th>Phone Number</th>
          <th>Activity</th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($clients as $client)
          <tr>
            <td>{{$client->firstName}} </td>
            <td>{{$client->lastName}}</td>
            <td>{{$client->email}}</td>
            <td>{{$client->address->phone_number}}</td>
            
            <td>
                @if ($client->last_login_at < $client->last_logout_at)
                    <i class="badge badge-danger">Offline</i>
                    @elseif ($client->last_login_at > $client->last_logout_at)
                    <i class="badge badge-success">Online</i>
                    @elseif ($client->last_login_at == '')
                    <i class="badge badge-danger">Offline</i>
                @endif
            </td>
            <td>
              <a href="{{route('clients.show', $client->id)}}" class="btn btn-primary btn-sm">
                <i class="fa fa-eye"></i> 
              </a>

              <a href="{{route('clients.edit', $client->id)}}" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i> </a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
  </div>
</div><!--/.row -->
</section>

</div><!--/.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor', 'manager', 'installer'])
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
        td = tr[i].getElementsByTagName("td")[0];
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
