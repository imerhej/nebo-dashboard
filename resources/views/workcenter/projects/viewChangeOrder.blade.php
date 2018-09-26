@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'supervisor', 'office-manager', 'manager'])
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
    <h2 class="h4 no-margin-bottom"> Change Order: <a href="{{route('projects.changeOrders', $project_id)}}"> {{$changeOrder->clientName}}</a> </h2> 
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

<div class="row has-shadow bg-white mt-2">
    <div class="col-xs-6 col-sm-6 col-md-6 mt-2 mb-2">
            <a href="{{route('projects.editChangeOrder', $changeOrder->id)}}" class="btn btn-success btn-sm fa fa-pencil" title="edit"></a>
    </div>
    @role(['superadministrator', 'administrator'])
    <div class="col-xs-6 col-sm-6 col-md-6 mt-2 mb-2">
        <form action="{{ route('projects.changeOrders', $changeOrder->id) }}" method="post" class="changorder_delete pull-right">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o" title="delete"></button>
        
        </form>
    </div>
    @endrole
</div>
<div class="row has-shadow bg-white mt-2">
    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="card mt-2">
            <div class="card-header">
                
            </div><!--/.card-header -->
            <div class="card-body">
                <label for="clientname">Client Name:</label>
                <span class="text-muted h6">{{$changeOrder->clientName}}</span><br>

                <label for="clientname">Lead Installer Name:</label>
                <span class="text-muted h6">{{$changeOrder->leadInstaller}}</span><br>

                <label for="clientname">Lead Installer Email:</label>
                <span class="text-muted h6">{{$changeOrder->clientName}}</span><br>

                <label for="clientname">Lead Installer Signature:</label>
                <span class="text-muted h6">{!! $changeOrder->leadinstaller_signature !!}</span><br>

                <label for="clientname">Request Date:</label>
                <span class="text-muted h6">{{date('F j Y @ h:i:s a', strtotime($changeOrder->created_at))}}</span><br>

                <label for="clientname">Request Update:</label>
                <span class="text-muted h6">{{date('F j Y @ h:i:s a', strtotime($changeOrder->updated_at))}}</span><br>
            </div><!--/.card-body -->
        </div><!--/.card -->

    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="card mt-2">
                <div class="card-header">

                </div><!--/.card-header -->
                <div class="card-body">
   
                    <label for="clientname">Order Details:</label>
                    <span class="text-muted h6">{!! $changeOrder->order_details !!}</span><br>

                    <label for="clientname">Client Signature:</label>
                    <span class="text-muted h6">{!! $changeOrder->client_signature !!}</span><br>
    
                    <label for="clientname">Signature Date:</label>
                    <span class="text-muted h6">{{date('F j Y @ h:i:s a', strtotime($changeOrder->client_signature_date))}}</span><br>
    
    
                </div><!--/.card-body -->
            </div><!--/.card -->
    
        </div>
</div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@role(['employee', 'client', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
  <script>

    $(document).ready(function(){
      $(".changorder_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection