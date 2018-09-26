@extends('layouts.workcenterlayout')

@section('content')
@if(Auth::user()->id == $client->id)
    <div class="container-fluid">
          <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="no-margin-bottom">My Account</h2>
            </div>
        </header>

        @foreach($errors->all() as $message)
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                {{ $message }}
            </div>
        @endforeach
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

        <div class="row bg-white has-shadow">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <strong>{{$client->firstName}} Details:</strong>
                            </div>

                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <a href="{{route('clients.editaccount', $client->id)}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i></a>
                            </div>
                        </div>
                            
                            
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
                        </div>
                    </div><!--/.card-body -->
                </div><!--/.card-->
            </div><!--/.clo-lg-12 -->
        </div><!--/.row -->
  
    </div><!--/.container-fluid -->
    @endif
    @if (Auth::user()->id != $client->id)
    @include('workcenter.errors.404')
    @endif
@endsection