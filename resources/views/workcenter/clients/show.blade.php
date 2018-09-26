@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
    <div class="container-fluid">
          <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h5 class="no-margin-bottom">Manage Account</h5>
                <h6 class="text-muted"><a href="{{route('clients.index')}}">Clients</a></h6>
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

                @if (session('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('danger') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row bg-white has-shadow">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                    <strong>{{$client->firstName}} Details:</strong>
                            </div>
                            <div class="col-6">
                                    @role(['superadministrator', 'administrator', 'office-manager'])
                                    <a href="{{route('clients.edit', $client->id)}}" class="btn btn-primary btn-sm fa fa-edit pull-right"></a>
                                    @if (Auth::user()->id != $client->id)
                                    <div class="field">
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="post" class="client_delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-right"></button>
                                        </form>
        
                                    {{-- {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'class' => 'delete']) !!}
                                    {!! Form::submit('', ['class' => 'fa fa-trash-o']) !!}
                                    {!! Form::close() !!} --}}
                                    </div>
                                    @endif
                                    @endrole
                            </div>
                        </div>
                            
                           
                            {{-- <a href="{{route('myaccount.edit', $user->id)}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i></a> --}}
                    </div><!--/.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="field">
                                    <p class="h6">Company Name: <span class="h6 text-muted">{{$client->firstName}}</span></p>
                                   </div>
                                 {{-- <div class="field">
                                    <p class="h6">Middle Name: <span class="h6 text-muted">{{$client->middleName}}</span></p>
                                </div> --}}
                                 <div class="field">
                                    <p class="h6">Contact Name: <span class="h6 text-muted">{{$client->lastName}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">E-mail: <span class="h6 text-muted">{{$client->email}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Phone Number: <span class="h6 text-muted">{{$client->address->phone_number}}</span></p>
                                </div>
                            </div><!--/.user-details -->
                            <div class="col-lg-4">
                                <div class="field">
                                    <p class="h6">Address 1: <span class="h6 text-muted">{{$client->address->address1}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Address 2: <span class="h6 text-muted">{{$client->address->address2}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">City: <span class="h6 text-muted">{{$client->address->city}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">State: <span class="h6 text-muted">{{$client->address->state}}</span></p>
                                </div>
                                <div class="field">
                                    <p class="h6">Zipcode: <span class="h6 text-muted">{{$client->address->zipcode}}</span></p>
                                </div>
                            </div><!--/.user-address -->
                            <div class="col-lg-4">
                               
                            </div><!--/.user-work-profile -->
                        </div>
                    </div><!--/.card-body -->
                </div><!--/.card-->
            </div><!--/.clo-lg-12 -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card mt-2">
                    <div class="card-header">
                        
                    </div><!--/.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-4">
                                <p class="h6">Current Project: {{$projects->count()}}</p>
                                @foreach ($projects as $project)
                                <span class="h6 text-muted"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a></span><br>
                                @endforeach
                                
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                @foreach ($client->roles as $role)
                                    <p class="h6">Role: <span class="h6 text-muted">{{$role->display_name}}</span></p>
                                @endforeach
                            </div>
                                <div class="col-lg-4 col-sm-4">
                                    <label for="activity">Activity Status:</label>
                                    @if ($client->last_login_at < $client->last_logout_at)
                                            <i class="badge badge-danger">Offline</i>
                                            @elseif ($client->last_login_at > $client->last_logout_at)
                                            <i class="badge badge-success">Online</i>
                                            @elseif ($client->last_login_at == '')
                                            <p class="badge badge-danger">Offline</p>
                                        @endif
                                        @if ($client->last_login_at< $client->last_logout_at)
                                        <pre>{{\Carbon\Carbon::parse($client->last_logout_at)->diffForHumans()}}</pre>
                                        @elseif ($client->last_login_at > $client->last_logout_at)
                                        <pre>{{\Carbon\Carbon::parse($client->last_login_at)->diffForHumans()}}</pre>
                                    @endif
                            </div>
                        </div>
                    </div><!--/.card-body-->
                </div><!--/.card-->
            </div><!--/.clo-lg-12 -->
                
        </div><!--/.row -->
        
    </div><!--/.container-fluid -->
    @endrole
    @role(['employee', 'client', 'supervisor', 'manager', 'installer'])
    @include('workcenter.errors.404')
    @endrole
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".client_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection