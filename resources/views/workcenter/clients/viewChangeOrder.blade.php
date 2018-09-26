@extends('layouts.workcenterlayout')

@section('content')
@if (Auth::user()->id == $changeOrder->client_id)
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Change Order</h2>
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
    <!-- Success Message-->
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
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <form action="{{route('clients.viewChangeOrder', $changeOrder->id)}}" method="POST">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}

            {{-- @role(['superadministrator'])
            <input type="hidden" name="user_id" value="{{$changeOrder->user_id}}">
            <input type="hidden" name="subject" value="Change Order - Updates">
            <input type="hidden" name="project_id" value="{{$changeOrder->project_id}}">
            <input type="hidden" name="client_id" value="{{$changeOrder->client_id}}">
            @endrole --}}
            <div class="modal-body">
              
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Client Name:</label>
                            <input type="text" name="clientName" value="{{$changeOrder->clientName}}" class="form-control" id="clientName" readonly>
                        </div>             
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                           
                            <label for="recipient-name" class="col-form-label">Lead Installer Name:</label>
                            <input type="text" name="leadInstaller" value="{{$changeOrder->leadInstaller}}" class="form-control" id="leadInstaller" readonly>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Change Order Details:</label>
                            <textarea name="order_details" class="form-control" id="order-details" readonly>{{$changeOrder->order_details}}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Client Signature:</label>
                            <input type="text" name="client_signature" value="{{$changeOrder->client_signature}}" class="form-control" id="client_signature" placeholder="Print Your Name" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Lead Installer Signature:</label>
                            <input type="text" name="leadinstaller_signature" value="{{$changeOrder->leadinstaller_signature}}" class="form-control" id="leadinstaller_signature" placeholder="Print Your Name" readonly>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
              <a href="{{route('clients.myproject', $changeOrder->client_id )}}" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</a>
              <input type="submit" class="btn btn-primary btn-sm" value="Update Request" id="update_request">
            </div>
            {{-- {!! Form::close() !!} --}}
        </form>
        </div>
    </div>
</div><!-- /.container-fluid -->
@elseif (Auth::user()->id != $changeOrder->client_id)
@include('workcenter.errors.404')
@endif
@endsection
@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
  <script>
     CKEDITOR.env.isCompatible = true;
    CKEDITOR.replace( 'order-details' );
    $(document).ready(function() {
        var s = $('#client_signature').val();
        if (s != '')
        {
            $('#client_signature').attr('readonly', 'readonly');
            $('#update_request').attr('disabled', 'disabled');
        } else if(s == '') {
            $('#client_signature').removeAttr('disabled');
            $('#update_request').removeAttr('disabled');
        }

    })
  </script>
@endsection