@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager', 'manager', 'employee', 'installer'])
@if (Auth::user()->id == $employee->id)
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h4 class="no-margin-bottom">{{$employee->firstName}} {{$employee->lastName}} - Performance Review </h4>
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
                <table class="table table-sm table-responsive mt-2">
                    <thead>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Review Date</th>
                        <th>Department</th>
                        <th>Manager</th>
                        <th>Employee Signature</th>
                        <th>Manager Signature</th>
                        <th>Signature Date</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($performances as $performance)
                        <tr>
                            <td>{{$performance->name}}</td>
                            <td>{{$performance->jobTitle}}</td>
                            <td>{{date('F j Y', strtotime($performance->review_date))}}</td>
                            <td>{{$performance->department}}</td>
                            <td>{{$performance->manager}}</td>
                            <td>{{$performance->employee_signature}}</td>
                            <td>{{$performance->manager_signature}}</td>
                            <td>{{date('F j Y', strtotime($performance->manager_date))}}</td>
                            <td><a href="{{route('myaccount.viewperformance', $performance->id)}}" class="btn btn-primary btn-sm fa fa-eye" title="view"></a></td>
                            <td><a href="{{route('myaccount.editperformance', $performance->id)}}" class="btn btn-success btn-sm fa fa-pencil" title="sign"></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div><!-- /.container-fluid -->
@endif
@endrole
@role(['client'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".performance_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection