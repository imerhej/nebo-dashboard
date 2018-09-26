@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
        <!-- Page Header-->
      <header class="page-header">
          <div class="container-fluid">
              <h2 class="no-margin-bottom">Message from {{$message->sender}}</h2>
          </div>
      </header>
      <div class="row bg-white has-shadow justify-content-md-center mt-2">
          <div class="col-md-8 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h6>From: {{$message->sender}}</h6>
                        </div>
                        <div class="col-6">
                            <h6 class="pull-right">Date: {{date('F j Y @ h:i a', strtotime($message->created_at))}}</h6>
                        </div>
                    </div>
                   
                </div><!--/.card-header -->
                <div class="card-body">
                    <h6>Subject: {{$message->subject}}</h6>
                    <h6>Message: </h6>
                    <p>{!!$message->message !!}</p>
                </div><!--/.card-body -->
            </div><!--/.card -->
          </div><!--/.col -->
      </div><!--/.row -->
</div><!--/.container-fluid-->
@endsection