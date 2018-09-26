@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">{{$permission->display_name}}</h2>
        </div>
    </header>
<!-- Buttons row -->
<div class="row bg-white has-shadow mt-2 ">
    <div class="col-lg-12 mt-3 mb-3">
        <a href="{{route('permissions.edit', $permission->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit Permission </a>
    </div>
</div><!--/.row -->
<!-- Permission Details -->
<div class="row bg-white has-shadow mt-2">
        <div class="col-lg-12">
            <div class="card mt-2">
              <div class="card-header">
                <strong>Permission Details</strong>
              </div>
              <div class="card-body">
                <p class="text-muted h5">Permission Display Name: {{$permission->display_name}}</p>
                <p class="text-muted h5">Permission Name (Slug): ({{$permission->name}})</p>
                <p class="text-muted h5">Description: {{$permission->description}}</p>
              </div>
            </div>
        </div>
      </div><!--/.row -->

</div><!--/.container-fluid -->
@endrole
@role(['administrator','employee', 'client', 'supervisor', 'manager', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection