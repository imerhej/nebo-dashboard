@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Create New Role</h2>
    </div>
</header>


 <!-- Create New Role Form -->
 <form action="{{route('roles.store')}}" method="POST">
        {{ csrf_field() }}
        <div class="row bg-white has-shadow mt-2">
        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-header"><strong>Create Role</strong></div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="display_name">Role Name</label>
                            <input type="text" name="display_name" id="display_name" class="form-control" value="{{old('display_name')}}" required>
                        </div>
    
                        <div class="form-group">
                            <label for="name">Slug (Can not be changed)</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" required>
                        </div>
    
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" id="description" value="{{old('description')}}">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm pull-right">Create New Role</button>
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
                          <input type="checkbox" value="{{$permission->id}}"  v-model="permissionsSelected"> {{$permission->display_name}} <em> - ({{$permission->description}})</em>
                      </div>
                  @endforeach                  
                </div>
            </div>
        </div><!-- /.col-md-6-->
     </div><!-- /.row -->
     </form>
     
    
    </div><!-- /.container -->
    @endrole
    @role(['administrator','employee', 'client', 'supervisor', 'manager', 'installer'])
  @include('workcenter.errors.404')
  @endrole
    @endsection
    
    @section('scripts')
    <script>
      var app = new Vue({
        el: '#app',
        data: {
          permissionsSelected: []
        }
      });
    </script>

@endsection