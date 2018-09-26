@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Daily Reports</h5>
            <a href="{{route('hrmanagement.employees')}}">Employees</a>
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
                    <th>Installer Name</th>
                    <th>Lead Installer</th>
                    <th>Project Name</th>
                    <th>Scope Of Work </th>
                    <th>Notes</th>
                    <th>Submitted At</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>
                            @foreach ($installers as $installer)
                                @if ($installer->id == $report->installer_id)
                                    {{$installer->firstName}} {{$installer->lastName}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$report->leadInstaller}}</td>
                        <td>
                            @foreach ($projects as $project)
                                @if ($project->id == $report->project_id)
                                    {{$project->projectName}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{str_limit($report->scope_work, 25)}}</td>
                        <td>{{str_limit($report->notes, 35)}}</td>
                        <td>{{date('F j Y @ h:i:s a', strtotime($report->created_at))}}</td>
                        <td><a href="{{route('hrmanagement.viewreport', $report->id)}}" class="btn btn-primary btn-sm fa fa-eye" title="View Report"></a></td>
                        <td><a href="{{route('hrmanagement.editreport', $report->id)}}" class="btn btn-success btn-sm fa fa-pencil" title="Edit Report"></a></td>
                        <td>
                            <form action="{{ route('hrmanagement.reports', $report->id) }}" method="post" class="report_delete">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o" title="delete"></button>
                            </form>    
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endrole
@role(['manager', 'supervisor', 'client', 'installer', 'employee'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".report_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
  @endsection