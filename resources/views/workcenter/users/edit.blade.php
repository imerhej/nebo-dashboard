@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Edit User</h2>
    </div>
</header>
<!-- Error Message -->
<div class="row mt-2">
    <div class="container-fluid">
        @if (session('warning'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                {{ session('warning') }}
            </div>
        @endif
    </div>
</div>
    <!-- Edit form -->
    <div class="row bg-white has-shadow mt-2">
      <div class="col-lg-12">
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
  
          <div class="row mt-2">
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header"><strong>Edit {{$user->firstName}} Details</strong></div>
                <div class="card-body">
  
                  <div class="field">
                      {{ Form::label('firstName', 'First Name:') }}
                      {{ Form::text('firstName', $user->firstName, ['class' => 'form-control', 'required' =>'']) }}
                  </div>

                  <div class="field">
                      {{ Form::label('middleName', 'Middle Name:') }}
                      {{ Form::text('middleName', $user->middleName, ['class' => 'form-control']) }}
                  </div>

                  <div class="field">
                      {{ Form::label('lastName', 'Last Name:') }}
                      {{ Form::text('lastName', $user->lastName, ['class' => 'form-control']) }}
                  </div>
                  <div class="field">
                    {{ Form::label('email', 'Email:') }}
                    {{ Form::email('email', $user->email, ['class' => 'form-control', 'required' =>'']) }}
                  </div>
  
                  <div class="field">
                    {{ Form::label('phone_number', 'Phone Number:') }}
                    {{ Form::text('phone_number', $userAddress->phone_number, ['class' => 'form-control', 'required' =>'']) }}
                  </div>
  
                  <div class="field">
                    <label for="password" class="m-t-10">Password</label>
                    <div class="field">
                      <input type="radio" name="password_options" value="keep" v-model="password_options"> Do not change password
                    </div>
  
                    <div class="field">
                      <input type="radio" name="password_options" value="auto" v-model="password_options"> Auto generate password
                    </div>
  
                    <div class="input-group" v-if="password_options == 'auto'">
                      <span class="input-group-addon">
                        <span class="fa fa-lock"></span>
                      </span>
                      <input :type="type" class="form-control" :placeholder="placeholder" :value="password" name="auto_password" required />
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary" @click="generate()">
                          <span class="fa fa-refresh"></span>
                        </button>
                      </span>
  
                      {{-- <span class="input-group-btn">
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Copy to Clipboard"
                          v-clipboard:copy="password"
                          v-clipboard:success="onCopy">
                        </button>
                      </span> --}}
                      </div>
  
                    <div class="field">
                      <input type="radio" name="password_options" value="manual" v-model="password_options"> Manually change password
                    </div>
  
                    <p>
                      <input type="password" class="form-control m-t-10" name="password" id="password" v-if="password_options == 'manual'" placeholder="Create Password Manually" required>
                      <label for="password_confirmation" class="m-t-10" v-if="password_options == 'manual'">Confirm Password</label>
                      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" v-if="password_options == 'manual'" placeholder="Repeat Password" required>
                    </p>
                  </div>
  
                </div>
              </div>
            </div>
            <!-- user Details -->
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-header"><strong>User Address</strong></div>
                  <div class="card-body">
                    <input type="hidden" name="user_id">
                    <div class="field">
                      {{ Form::label('address1', 'Address Line 1:') }}
                      {{ Form::text('address1', $userAddress->address1, ['class' => 'form-control', 'required' =>'', 'placeholder' => '123 N Main St']) }}
                    </div>
  
                    <div class="field">
                      {{ Form::label('address2', 'Address Line 2:') }}
                      {{ Form::text('address2', $userAddress->address2, ['class' => 'form-control', 'placeholder' => 'Apartment, suite, unit, floor, building, etc.']) }}
                    </div>
  
                    <div class="field">
                      {{ Form::label('city', 'City:') }}
                      {{ Form::text('city', $userAddress->city, ['class' => 'form-control', 'required' => '']) }}
                    </div>
  
                    <div class="field">
                        {{ Form::label('state', 'State:') }}
                        {{ Form::select('state', $states, $userAddress->state,  ['class' => 'form-control', 'placeholder' => 'Select State', 'required' => '']) }}
                    </div>
  
                    <div class="field">
                        {{ Form::label('zipcode', 'Zip Code:') }}
                        {{ Form::text('zipcode', $userAddress->zipcode, ['class' => 'form-control', 'required' => '']) }}
                    </div>
  
                  </div>
                </div>
              </div>
              <!-- Work profile -->
            <div class="col-lg-4">
                <div class="card">
                  <div class="card-header"><strong>Work Profile</strong></div>
                  <div class="card-body">
                    <!-- <input type="hidden" name="user_id"> -->
                    <div class="field">
                        {{ Form::label('payrate', 'Pay Rate') }}
                    <input type="text" name="payrate" id="payrate" value="{{$userProfile->payrate}}" class="form-control">
                      </div>
    
                    <div class="field">
                      {{ Form::label('status', 'Employee Status:')}}
                      <select name="status" id="status" required class="form-control">
                        <option value="">- Select -</option>
                        <option value="Active" {{$userProfile->status == 'Active' ? 'selected' : ''}}>Active</option>
                        <option value="Terminated" {{$userProfile->status == 'Terminated' ? 'selected' : ''}}>Terminated</option>
                      </select>
                    </div>

   
                    <div class="field">
                      {{ Form::label('employeeType', 'Employee Type: ') }}
                      <select name="employeeType" id="employeeType" required class="form-control">
                          <option value="">- Select -</option>
                      <option value="Full Time" {{$userProfile->employeeType == 'Full Time' ? 'selected' : ''}}>Full Time</option>
                          <option value="Part Time" {{$userProfile->employeeType == 'Part Time' ? 'selected' : ''}}>Part Time</option>
                          <option value="On Contract" {{$userProfile->employeeType == 'On Contract' ? 'selected' : ''}}>On Contract</option>
                          <option value="Sub Contract" {{$userProfile->employeeType == 'Sub Contract' ? 'selected' : ''}}>Sub Contract</option>
                        </select>
                      </div>
           
                    <div class="form-group">
                      {{ Form::label('hireDate', 'Hire Date:') }}
                        <input type="text" name="hireDate" value="{{$userProfile->hireDate}}" id="hireDate" class="form-control" required>
                    </div>
    
                     <div class="form-group">
                         {{ Form::label('department', 'Department:') }}
                         <select name="department_id" id="" class="form-control">
                            @foreach($departments as $department)
                              @foreach ($user->department as $userdepartment)
                              <option value="{{$department->id}}" {{ $userdepartment->id === $department->id ? 'selected' : '' }}>{{$department->departmentTitle}}</option>
                              @endforeach
                            @endforeach
                         </select>
                      </div>
                      
                      <div class="form-group">
                          {{ Form::label('notes', 'Notes:') }}
                          <textarea name="notes" class="form-control">{{$userProfile->notes}}</textarea>
                       </div>
                     </div>
                  </div>
                </div>
              </div><!--/.row-->
     
          <div class="row mt-2">
            @role(['superadministrator', 'administrator', 'office-manager'])
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header"><strong>Select Permissions</strong></div>
                <div class="card-body">
                  <input type="hidden" v-model="selectedPermissions" name="permissions">
                    @foreach ($permissions as $permission)
                  <div class="field">
                    <input type="checkbox" value="{{$permission->id}}" v-model="selectedPermissions"> {{$permission->display_name}}
                  </div>
                    @endforeach
  
                </div>
              </div>
            </div>
  
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header"><strong>Select Roles</strong></div>
                <div class="card-body">
                  <input type="hidden" v-model="selectedRoles" name="roles">
                    @foreach ($roles as $role)
                  <div class="field">
                    <input type="checkbox" value="{{$role->id}}" v-model="selectedRoles"> {{$role->display_name}}
                  </div>
                    @endforeach
                    {{ Form::submit('Save Changes', ['class' => 'btn btn-primary m-t-10']) }}
                </div>
              </div>
            </div>
            @endrole
        </div><!--/.row -->
  
        {!! Form::close() !!}
      </div><!--/.col-lg-12 -->
    </div><!--/.row -->
    
    </div><!--/.container -->
@endsection
@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        selectedRoles: {!! $user->roles->pluck('id') !!},
        selectedPermissions: {!! $user->permissions->pluck('id') !!},
        password_options: 'keep',
        password: this.value,
      },
      props: {
        type: {
          type: String,
          default: 'text'
        },
        size: {
          type: String,
          default: '12'
        },
        characters: {
          type: String,
          default: 'a-z,A-Z,0-9'
        },
        placeholder: {
          type: String,
          default: 'Auto generated password'
        },
        auto: [String, Boolean],
        value: ''
      },
      mounted: function() {
        if(this.auto == 'true' || this.auto == 1) {
          this.generate();
        }
      },
      methods: {
            onCopy: function (e) {
                alert('You just copied: ' + e.text)
                },
            generate: function() {
          let charactersArray = this.characters.split(',');
          let CharacterSet = '';
          let password = '';

          if( charactersArray.indexOf('a-z') >= 0) {
            CharacterSet += 'abcdefghijklmnopqrstuvwxyz';
          }
          if( charactersArray.indexOf('A-Z') >= 0) {
            CharacterSet += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          }
          if( charactersArray.indexOf('0-9') >= 0) {
            CharacterSet += '0123456789';
          }
          // if( charactersArray.indexOf('#') >= 0) {
          //   CharacterSet += '![]{}()%&*$#^<>~@|';
          // }

          for(let i=0; i < this.size; i++) {
            password += CharacterSet.charAt(Math.floor(Math.random() * CharacterSet.length));
          }
          this.password = password;
        },
        done: function () {
          alert('The Password has been Copied to Clipboard!')
        }
      }
    });
    $(document).ready(function(){
      
      $( "#hireDate" ).datepicker({
          dateFormat: "yy-mm-dd"
      });
      $('#phone_number').mask('(000) 000-0000');
   });
  </script>
@endsection