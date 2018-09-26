@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom"> New Permissions</h2>
        </div>
    </header>
<!-- Create form -->
<form action="{{route('permissions.store')}}" method="post">
        {{ csrf_field() }}
    <div class="row bg-white has-shadow mt-2">
      <div class="col-8 mt-2">
        <div class="card">
          <div class="card-body">
            <div class="card-header"><strong>Select Permission Type</strong></div>

          <div class="field mt-3 mb-3">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline1" value="basic" name="permission_type" v-model="permissionType" class="custom-control-input">
                  <label class="custom-control-label" for="customRadioInline1">Basic permission</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline2" value="crud" name="permission_type" v-model="permissionType" class="custom-control-input">
                  <label class="custom-control-label" for="customRadioInline2">CRUD permission</label>
              </div>
          </div>

          <div class="field" v-if="permissionType == 'basic'">
            <label for="display_name">Name (Display Name)</label>
            <p>
              <input type="text" name="display_name" id="display_name" class="form-control" required>
            </p>
          </div>

          <div class="field" v-if="permissionType == 'basic'">
            <label for="name">Slug</label>
            <p>
              <input type="text" name="name" id="name" class="form-control" required>
            </p>
          </div>

          <div class="field" v-if="permissionType == 'basic'">
            <label for="description">Description</label>
            <p>
              <input type="text" name="description" id="description" class="form-control" placeholder="Describe what this permission does!" required>
            </p>
          </div>

      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="field" v-if="permissionType == 'crud'">
          <label for="resource">Resource</label>
          <p>
            <input type="text" name="resource" id="resource" v-model="resource" class="form-control" placeholder=" The name of the resource!">
          </p>
        </div>

        <div class="field" v-if="permissionType == 'crud'">
          <div class="field">
            <input type="checkbox" name="create" value="create" v-model="crudSelected"> Create
          </div>
          <div class="field">
            <input type="checkbox" name="read" value="read" v-model="crudSelected"> Read
          </div>
          <div class="field">
            <input type="checkbox" name="update" value="update" v-model="crudSelected"> Update
          </div>
          <div class="field">
            <input type="checkbox" name="delete" value="delete" v-model="crudSelected"> Delete
          </div>
        </div>
        <input type="hidden" name="crud_selected" v-model="crudSelected">

        <div class="field">
          <table class="table" v-if="resource.length >= 3">
            <thead>
              <th>Name</th>
              <th>Slug</th>
              <th>Description</th>
            </thead>
            <tbody>
              <tr v-for="item in crudSelected">
                <td v-text="crudName(item)"></td>
                <td v-text="crudSlug(item)"></td>
                <td v-text="crudDescription(item)"></td>
              </tr>
            </tbody>
          </table>
        </div>
      <button type="submit" class="btn btn-primary btn-sm pull-right">Create Permission</button>
    </div>
  </div>
 </div><!--/.col-8 -->
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