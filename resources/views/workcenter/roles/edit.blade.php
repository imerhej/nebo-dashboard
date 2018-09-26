@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
  <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Edit Role</h2>
    </div>
</header>
    
      <!-- Edit Role Form -->
    <form action="{{route('roles.update', $role->id)}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row bg-white has-shadow mt-2">
            <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header"><strong>Edit {{$role->display_name}} Role</strong></div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="display_name">Role Name</label>
                            <input type="text" name="display_name" id="display_name" class="form-control" value="{{$role->display_name}}">
                        </div>
    
                        <div class="form-group">
                            <label for="name">Slug (Can not be changed)</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{$role->name}}" disabled>
                        </div>
    
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" id="description" value="{{$role->description}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm pull-right">Update Role</button>
                        </div>
                        <input type="hidden" v-model="permissionsSelected" name="permissions">
                </div>
            </div>
        </div><!-- /.col-md-6-->

        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header"><strong>Select Permissions</strong></div>
                <div class="card-body">
                  @foreach ($permissions as $permission)
                    <div class="field">
                      <input type="checkbox" value="{{$permission->id}}" v-model="permissionsSelected"> {{$permission->display_name}} - <em>({{$permission->name}})</em>
                    </div>
                  @endforeach
                  
                    </div><!--/.card-body -->
                </div><!--/.card -->
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
      </form>
     </div><!-- /.container -->
     @endrole
     @role(['employee', 'client', 'supervisor'])
     @include('workcenter.errors.404')
     @endrole
    
    @endsection
    
    @section('scripts')
      <script>
        var app = new Vue({
          el: '#app',
          data: {
                permissionsSelected: {!!$role->permissions->pluck('id') !!}
          }
        });
      </script>
@endsection