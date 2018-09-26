@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">

  <!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Add Client</h2>
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
  
    <!-- Create form -->
    <div class="row bg-white has-shadow mt-2">
      <div class="col-lg-12">
        {!! Form::open(array('route' => 'clients.store')) !!}
          <div class="row mt-2">
            <!-- Personal Details -->
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header"><strong>Client Details</strong></div>
                <div class="card-body">
                  {{ Form::hidden('client_id')}}
                  <div class="field">
                    {{ Form::label('CompanyName', 'Company Name:') }}
                    {{ Form::text('firstName', null, ['class' => 'form-control', 'required' =>'']) }}
                  </div>
                  {{-- <div class="field">
                    {{ Form::label('middleName', 'Middle Name:') }}
                      {{ Form::text('middleName', null, ['class' => 'form-control']) }}
                  </div> --}}
                  <div class="field">
                  {{ Form::label('lastName', 'Contact Name:') }}
                    {{ Form::text('lastName', null, ['class' => 'form-control']) }}
                  </div>
                  <div class="field">
                    {{ Form::label('email', 'Email:') }}
                    {{ Form::email('email', null, ['class' => 'form-control', 'required' =>'']) }}
                  </div>
  
                  <div class="field">
                    {{ Form::label('phone_number', 'Phone Number:') }}
                    {{ Form::text('phone_number', null, ['class' => 'form-control', 'required' =>'']) }}
                  </div>
                 
                </div><!--/.card-body -->
              </div><!--/.card -->
            </div><!--/.col-lg-4 -->
          <!-- Address -->
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header"><strong>Address</strong></div>
                <div class="card-body">
                  <!-- <input type="hidden" name="user_id"> -->
  
                  <div class="field">
                    {{ Form::label('address1', 'Address Line 1:') }}
                    {{ Form::text('address1', null, ['class' => 'form-control', 'placeholder' => '123 N Main St']) }}
                  </div>
  
                  <div class="field">
                    {{ Form::label('address2', 'Address Line 2:') }}
                    {{ Form::text('address2', null, ['class' => 'form-control', 'placeholder' => 'Apartment, suite, unit, floor, building, etc.']) }}
                  </div>
  
                  <div class="field">
                    {{ Form::label('city', 'City:') }}
                     {{ Form::text('city', null, ['class' => 'form-control']) }}
                  </div>
  
                   <div class="field">
                       {{ Form::label('state', 'State:') }}
                       {{ Form::select('state', $states,[], ['class' => 'form-control', 'placeholder' => 'Select State']) }}
                   </div>
  
                   <div class="field">
                      {{ Form::label('zipcode', 'Zip Code:') }}
                      {{ Form::text('zipcode', null, ['class' => 'form-control']) }}
                   </div>
  
                </div><!--/.card-body -->
              </div><!--/.card -->
            </div><!--/.col-lg-4 -->
            <!-- Work profile -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><strong>Select Roles</strong></div>
                        <div class="card-body">
                            <input type="hidden" v-model="selectedRoles" name="roles">
                            @foreach ($roles as $role)
                            <div class="field">
                            <input type="checkbox" value="{{$role->id}}" v-model="selectedRoles"> {{$role->display_name}}
                            </div>
                            @endforeach
            
                            
                        </div>
                </div>

            </div><!--/.col-lg-4 -->
          </div><!--/.row -->
          <div class="row">
              <div class="col-lg-4">

                  <div class="field">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" v-model="auto_password" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Auto Generate Password:</label>
                        </div>
  
                        {{-- <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" v-if="!auto_password" placeholder="Repeat Password" required>
                        <input type="checkbox" class="m-t-10" v-model="auto_password" > Auto Generate Password: --}}
    
                        <div class="input-group" v-if="auto_password">
  
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
                             v-clipboard:success="done">Copy!
                            </button>
                          </span> --}}
                         </div>
                        </div>
                      {{-- </div>
                        <div class="col-lg-3"> --}}
                            <div class="field">
                              <label for="password" v-if="!auto_password">Password:</label>
                              <input type="password" class="form-control" name="password" id="password" v-if="!auto_password" placeholder="Create Password Manually" required>
                            </div>
                        {{-- </div>
                        <div class="col-lg-3"> --}}
                            <div class="field">
                                <label for="password_confirmation" class="" v-if="!auto_password">Confirm Password:</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" v-if="!auto_password" placeholder="Repeat Password" required>
                            </div>
                        </div> 
                    
          </div>
          
          <!-- Permissions -->
          <div class="row mt-2">
            {{-- <div class="col-lg-6">
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
            </div> --}}
  
            <!-- Roles -->
            <div class="col-lg-12">
                {{ Form::submit('Create New Client', ['class' => 'btn btn-primary mb-4 pull-right']) }}
            </div>
        </div><!--/.row -->
        {!! Form::close() !!}
      </div><!--/.col-lg-12 -->
    </div><!--/.row -->
  
  </div><!--/.container -->
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
        selectedRoles: [],
        selectedPermissions: [],
        department_id: this.value,
        auto_password: true,
        password: this.value
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
          default: 'Auto generate password'
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
    // $(function () {
    //   $('[data-toggle="tooltip"]').tooltip()
    // })
  </script>
@endsection