@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Permissions</h2>
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

        <!-- Buttons row -->
    <div class="row bg-white has-shadow">
        <div class="col-lg-12 mt-3 mb-3">
            <a href="{{route('permissions.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Create Permissions </a>
        </div>
      </div><!--/.row -->

      <!-- All Permissions -->
  <div class="row bg-white has-shadow mt-2">
        <div class="col-lg-12">
            <table class="table table-hover table-sm table-striped table-responsive">
              <thead>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($permissions as $permission)
                <tr>
                  <td>{{$permission->name}}</td>
                  <td>{{$permission->display_name}}</td>
                  <td>{{$permission->description}}</td>
                  <td>{{date('F j Y', strtotime($permission->created_at))}}</td>
                  <td>{{date('F j Y', strtotime($permission->updated_at))}}</td>
                  <td>
                    <a href="{{route('permissions.show', $permission->id)}}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{route('permissions.edit', $permission->id)}}" class="btn btn-default btn-sm">Edit</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <span class="mt-2 mb-4">{{$permissions->links()}}</span>
        </div>
      </div><!--/.row -->
    </div><!--/.container-fluid -->
    @endrole
    @role(['administrator','employee', 'client', 'supervisor', 'manager', 'installer'])
  @include('workcenter.errors.404')
  @endrole
@endsection
@section('scripts')

</script>
@endsection