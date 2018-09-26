@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
 <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">{{$role->display_name}}</h2>
    </div>
</header

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



<!-- Buttons row -->
  <div class="row bg-white has-shadow mt-2">
    <div class="col-lg-12 mt-2 mb-2">
        <a href="{{route('roles.edit', $role->id)}}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit This Role </a>
    </div>
  </div><!--/.row -->

<!-- Role Details -->
  <div class="row bg-white has-shadow mt-2">
    <div class="col-lg-12 m-b-15">
        <div class="card mt-2">
          <div class="card-header">
            {{$role->display_name}}
          </div>
          <div class="card-body">
            <h4 class="card-title">Role Name:</h4> ({{$role->name}})
            <h4 class="card-title">Description:</h4> {{$role->description}}
            <h4 class="card-title">Permissions:</h4>
            <ul>
              @foreach($role->permissions as $rol)
                <li>{{ $rol->display_name }} <em>({{ $rol->description }})</em></li>
              @endforeach
            </ul>
          </div>
        </div>
    </div>
  </div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor'])
@include('workcenter.errors.404')
@endrole
@endsection
