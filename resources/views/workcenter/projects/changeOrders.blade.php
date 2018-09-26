@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager', 'supervisor', 'manager'])
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="h4 no-margin-bottom"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> </h2> 
        <span class="text-muted">Change Order</span>
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
    <div class="col-xs-12 col-sm-12 col-md-12">
        <table class="table table-sm table-responsive mt-2">
            <thead>
                <th>Client name</th>
                <th>Lead Installer</th>
                <th>Order Details</th>
                <th>Lead Signature</th>
                <th>Client Signature</th>
                <th>Submitted At</th>
                <th></th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($changeOrders as $changeOrder)
                <tr>
                    <td>{{$changeOrder->clientName}}</td>
                    <td>{{$changeOrder->leadInstaller}}</td>
                    <td>{!! str_limit($changeOrder->order_details, 50) !!}</td>
                    <td>{{$changeOrder->leadinstaller_signature}}</td>
                    <td>{{$changeOrder->client_signature}}</td>
                    <td>{{date('F j Y', strtotime($changeOrder->created_at))}}</td>
                    <td>
                        <a href="{{route('projects.viewChangeOrder', $changeOrder->id)}}" class="btn btn-primary btn-sm fa fa-eye" title="view"></a>
                    </td>
                    <td>
                        <a href="{{route('projects.editChangeOrder', $changeOrder->id)}}" class="btn btn-success btn-sm fa fa-pencil" title="edit"></a>
                    </td>
                    <td>
                        @role(['superadministrator', 'administrator', 'manager'])
                        <div class="col-sm-3">
                            <form action="{{ route('projects.changeOrders', $changeOrder->id) }}" method="post" class="changorder_delete">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o" title="delete"></button>
                            
                                </form>
                        </div>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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