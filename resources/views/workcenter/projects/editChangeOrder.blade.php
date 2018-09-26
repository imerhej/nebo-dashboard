@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager', 'supervisor', 'manager'])
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Edit Change Order</h2>
        </div>
</header>
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
            <form action="{{route('projects.editChangeOrder', $changeOrder->id)}}" method="POST">
            {{-- {!! Form::model($changeOrder, ['route' => ['projects.editChangeOrder', $changeOrder->id], 'method' => 'PUT']) !!} --}}
                        {{csrf_field()}}
                        {{ method_field('PUT') }}

            {{-- <input type="hidden" name="leadInstaller" value="{{$user->firstName}} {{$user->lastName}}"> --}}
            <input type="hidden" name="user_id" value="{{$changeOrder->user_id}}">
            {{-- <input type="hidden" name="supervisorEmail" value="{{$user->email}}"> --}}

            <input type="hidden" name="subject" value="Change Order - Updates">
            <input type="hidden" name="project_id" value="{{$project_id}}">
            <input type="hidden" name="client_id" value="{{$changeOrder->client_id}}">
            {{-- <input type="hidden" name="clientName" value="{{$project->projectDetail->clientName}}"> --}}
            {{-- <input type="hidden" name="clientEmail" value="{{$clientproject->email}}"> --}}

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
                            <textarea name="order_details" class="form-control" id="order-details" required>{{$changeOrder->order_details}}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Client Signature:</label>
                            <input type="text" name="client_signature" class="form-control" id="client_signature" placeholder="Print Your Name" readonly>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Lead Installer Signature:</label>
                            <input type="text" name="leadinstaller_signature" value="{{$changeOrder->leadinstaller_signature}}" class="form-control" id="leadinstaller_signature" placeholder="Print Your Name" required>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
              <a href="{{route('projects.viewChangeOrder', $changeOrder->id )}}" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</a>
              <input type="submit" class="btn btn-primary btn-sm" value="Update Request">
            </div>
            {{-- {!! Form::close() !!} --}}
        </form>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endrole
@role(['employee', 'client', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
  <script>
     CKEDITOR.env.isCompatible = true;
    CKEDITOR.replace( 'order-details' );
    
  </script>
@endsection