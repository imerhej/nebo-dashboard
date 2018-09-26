@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom"> Edit Permission</h2>
        </div>
    </header>
 <!-- Create form -->
 <form action="{{route('permissions.update', $permission->id)}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row bg-white has-shadow mt-2">
          <div class="col-8">
            <div class="card mt-2">
              <div class="card-body">
                <div class="card-header"><strong>Edit Permission</strong></div>
    
              <div class="field mt-3 mb-3" v-if="permissionType == 'basic'">
                <!-- <div class="field m-t-10"> -->
                <label for="display_name">Name (Display Name)</label>
                <p>
                  <input type="text" name="display_name" id="display_name" class="form-control" value="{{$permission->display_name}}" required>
                </p>
              </div>
    
              <div class="field" v-if="permissionType == 'basic'">
                <label for="name">Slug</label>
                <p>
                  <input type="text" name="name" id="name" class="form-control" value="{{$permission->name}}" required disabled>
                </p>
              </div>
    
              <div class="field" v-if="permissionType == 'basic'">
                <label for="description">Description</label>
                <p>
                  <input type="text" name="description" id="description" class="form-control" value="{{$permission->description}}" placeholder="Describe what this permission does!" required>
                </p>
              </div>
              <button type="submit" class="btn btn-primary btn-sm pull-right">Save Changes</button>
          </div>
        </div>
     </div>
    </div><!--/.row -->
    </form>
</div><!--/.container-fluid -->
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
        permissionType: 'basic',
        resource: '',
        crudSelected: ['create', 'read', 'update', 'delete']
      },
      methods: {
        crudName: function(item) {
          return item.substr(0,1).toUpperCase() + item.substr(1) + " " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
        },
        crudSlug: function(item) {
          return item.toLowerCase() + "-" + app.resource.toLowerCase();
        },
        crudDescription: function(item) {
          return "Allow a User to " + item.toUpperCase() + " a " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
        }
      }
    });
  </script>
@endsection