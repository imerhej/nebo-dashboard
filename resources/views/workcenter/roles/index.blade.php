@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Roles</h2>
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
        <div class="row bg-white has-shadow ">
              <!-- Item -->
              <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                      <div class="title mt-2 mb-2">
                          <a href="{{route('roles.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Create New Role </a>
                      </div>
                  </div>
              </div>
          </div><!--/.row -->

  <!-- Roles Cards -->
  <div class="row bg-white has-shadow mt-2">
  @foreach($roles as $role)
    <div class="col-sm-3 mt-2">
      <div class="card" id="card">
        <div class="card-body">
          <h4 class="card-title text-center">{{ $role->display_name }}</h4>
          <p class="card-text">{{ $role->description }}</p>
          <h6 class="h6"><strong>Created at:</strong> {{date('F j, Y', strtotime($role->created_at))}}</h6>
          <a href="{{ route('roles.show', $role->id) }}" class="btn btn-primary btn-sm">Details</a>
          <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-secondary btn-sm pull-right">Edit</a>
        </div>
      </div>
    </div>
    @endforeach
  </div><!-- /.row -->
  
  </div><!--/.container-fluid -->
  @endrole
  @role(['administrator','employee', 'client', 'supervisor', 'manager', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection