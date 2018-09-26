@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Compose Message</h2>
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
  <div class="row mt-1">
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
    <section class="create-message">
        <div class="row bg-white has-shadow justify-content-md-center">
            <div class="col-xs-9 col-sm-9 col-md-9">
                <div class="card mt-2">
                    <div class="card-header">
                        <h6>New Message</h6>
                    </div><!--/.card-header-->
                        <div class="card-body">
                            {!! Form::open(array('route' => 'messages.store')) !!}
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <input type="hidden" name="sender" value="{{Auth::user()->firstName}} {{Auth::user()->lastName}}">
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Recipient:</label>
                              <select class="form-control " name="recipient" required>
                                  <option value="">- Select Recipient -</option>
                                    @foreach ($users as $user)                       
                                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                                    @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="message-subject" class="col-form-label">Subject:</label>
                                <input name="subject" type="text" class="form-control" id="subject">
                            </div>
            
                            <div class="form-group">
                              <label for="message-text" class="col-form-label">Message:</label>
                              <textarea name="message" class="form-control" id="message-text" required></textarea>
                            </div>
                            {{ Form::submit('Send Message', ['class' => 'btn btn-primary btn-sm pull-right']) }}
                            {{-- <button type="button" class="btn btn-primary btn-sm pull-right">Send message</button> --}}
            
                        {!! Form::close() !!}
                    </div><!--/.card-body-->
                </div><!--/.card-->
            </div>
        </div><!--/.row-->
    </section><!--/.section-->
</div><!--/.container-fluid-->
@endsection
@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.env.isCompatible = true;
        CKEDITOR.replace( 'message-text' );
    </script>
@endsection