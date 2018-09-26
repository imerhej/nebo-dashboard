@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
        <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Edit Account</h2>
        </div>
    </header>

    <div class="row bg-white has-shadow mt-2">
        <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card mt-2">
                        <div class="card-header">
                            <strong>{{$user->firstName}} {{$user->lastName}} Details:</strong>   
                        </div><!--/.card-header -->
                        <div class="card-body">
                            {!! Form::model($user, ['route' => ['myaccount.update', $user->id], 'method' => 'PUT']) !!}
                            <div class="row">
                                <div class="col-lg-6">
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
                                        {{ Form::text('lastName', $user->lastName, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                    <div class="field">
                                        {{ Form::label('email', 'E-mail:') }}
                                        {{ Form::text('email', $user->email, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                    <div class="field">
                                        {{ Form::label('phone_number', 'Phone Number:') }}
                                        {{ Form::text('phone_number', $user->address->phone_number, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                </div><!--/.user-details -->
                                <div class="col-lg-6">
                                    <div class="field">
                                        {{ Form::label('address1', 'Address 1:') }}
                                        {{ Form::text('address1', $user->address->address1, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                    <div class="field">
                                        {{ Form::label('address2', 'Address 2:') }}
                                        {{ Form::text('address2', $user->address->address2, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="field">
                                        {{ Form::label('city', 'City:') }}
                                        {{ Form::text('city', $user->address->city, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                    <div class="field">
                                            {{ Form::label('state', 'State:') }}
                                            {{ Form::select('state', $states ,$user->address->state, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                    <div class="field">
                                            {{ Form::label('zipcode', 'Zipcode:') }}
                                            {{ Form::text('zipcode', $user->address->zipcode, ['class' => 'form-control', 'required' =>'']) }}
                                    </div>
                                    
                                </div><!--/.user-address -->
                            
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="password" class="mt-2">Password:</label>
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
                                        <input :type="type" class="form-control" :placeholder="placeholder" :value="password" name="auto_password" />
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

                                    <div class="field">
                                        <input type="radio" name="password_options" value="manual" v-model="password_options"> Manually change password
                                    </div>
                                    <div class="field">
                                        <input type="password" class="form-control m-t-10" name="password" id="password" v-if="password_options == 'manual'" placeholder="Create Password Manually" required>
                                        <label for="password_confirmation" class="m-t-10" v-if="password_options == 'manual'">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" v-if="password_options == 'manual'" placeholder="Repeat Password" required>
                                    </div>
                                    <div class="field">
                                        {{ Form::submit('Save Changes', ['class' => 'btn btn-primary btn-sm pull-right mt-2']) }}
                                    </div>

                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div><!--/.card-body -->
                    </div><!--/.card-->
        </div><!--/.clo-lg-12 -->
    </div><!--/.row -->
</div><!--/.container-fluid -->
@endsection
@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        selectedRoles: {!! $user->roles->pluck('id') !!},
        password_options: 'keep',
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

  </script>
@endsection