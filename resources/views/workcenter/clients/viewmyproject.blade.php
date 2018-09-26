@extends('layouts.workcenterlayout')

@section('content')
@if (Auth::user()->id == $client->id)
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">{!! $myproject->projectName !!}</h2>
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
    
    <div class="row bg-white has-shadow ">
        <div class="col-xs-6 col-sm-6 col-md-6">  
            
            <p class="h6 mt-3">Project Details: <span class="text-muted text-justify">{{$myproject->description}} </span></p>
            <p class="h6 mt-3">Project Number: <span class="text-muted">{!! $myproject->projectName !!} </span></p>
            <p class="h6 mt-3">Start Date: <span class="text-muted">{{date('F j Y', strtotime($myproject->start_date))}} </span></p>
            <p class="h6 mt-3">End Date: <span class="text-muted">{{date('F j Y', strtotime($myproject->end_date))}} </span></p>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
                <p class="h6 mt-3">Supervisor: <span class="text-muted text-justify">{{$super->firstName}} {{$super->lastName}}</span></p>
                <p class="h6 mt-3">Phone Number: <span class="text-muted">{{$userdetails->phone_number}} </span></p>
        </div>
        
    </div>
    <!-- Calendar Display -->
    <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-8 col-sm-8 col-md-8 mt-2">  
                    {!! $projectdetails->calendar() !!}
                    {!! $projectdetails->script() !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 mt-2">  
                    <div class="card">

                        <div class="card-body">
                                <label for="recieved-files">Recieved Files</label>
                            <table>
                                <thead>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                    <tr>
                                        <td>{!! str_limit($file->tasklist_file, 30) !!}</td>
                                        <td><a href="/storage/documents/{{($file->tasklist_file)}}" target="_blank" title="download" class="btn btn-primary btn-sm fa fa-download pull-right"></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card">
                            <div class="card-body">
                                <label for="Change order request">Change order request</label>
                                <table>
                                    <thead>
                                        <th></th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($changeOrders as $changeOrder)
                                        <tr>
                                            <td>Change Order {!! $myproject->projectNumber !!}</td>
                                            <td><a href="{{route('clients.viewChangeOrder', $changeOrder->id)}}" title="view" class="btn btn-primary btn-sm fa fa-eye pull-right"></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
            </div>
        </div>

        
</div><!--/.container-fluid -->
@elseif (Auth::user()->id != $client->id)
@include('workcenter.errors.404')
@endif

@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".project_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection