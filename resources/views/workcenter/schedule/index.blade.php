@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form class="" action="{{route('schedule.index')}}" method="POST">
                {{csrf_field()}}
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Schedule</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
                <div class="form-group">
                  <label for="project" class="text-muted">Select Project:</label>
                  <select name="project_id" id="" class="form-control" required>
                        <option value="">- Select Project -</option>
                        @foreach($projects as $project)
                            <option value="{{$project->id}}">{{$project->projectName}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                  <label for="installer" class="text-muted">Select Installer:</label>
                  <select class="form-control select2-multi"  name="installer_id[]" multiple="multiple" style="width: 100%;" required>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="installer" class="text-muted">Select Equipment:</label>
                    <select class="form-control select2-multi"  name="equipment_name[]" multiple="multiple" style="width: 100%;" >
                            @foreach($inventories as $inventory)
                                <option value="{{$inventory->name}}">{{$inventory->name}} {{$inventory->model}}</option>
                            @endforeach
                        </select>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_date" class="text-muted">Start Date:</label>
                            <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end_date" class="text-muted">End Date:</label>
                            <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" required>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
          </div>
        </form>
        </div>
      </div>          
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Schedule Projects / Installers </h5>
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

    <!-- Warning Message-->
    <div class="row mt-2">
            <div class="container-fluid">
                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('warning') }}
                    </div>
                @endif
            </div>
        </div>

    @foreach($errors->all() as $message)
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @endforeach

    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
              <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#schedule" data-whatever="@mdo">Schedule Installers / Equipments</button>
        </div>
    </div> <!--/.row -->
    <div class="row bg-white has-shadow mt-2">
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card mt-2">
                <div class="card-header">
                    <h6 class="text-muted">Double Bookings:</h6>
                        @foreach ($flagCounts as $flagCount)
                        <span class="bage badge-pill badge-warning text-small text-muted">{{$flagCount->firstName}} {{$flagCount->lastName}} </span>
                    @endforeach
                </div>
                <div class="card-body">
                    <table class="table table-sm table-responsive">
                        <thead>
                            <th>Installer</th>
                            <th>Project</th>
                            <th>Equipment</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($schedules  as $schedule)

                            <tr>
                                <td>
                                    {{$schedule->firstName}} {{$schedule->lastName}}
                                </td>
                                <td>
                                    {{$schedule->projectName}}
                                </td>
                                <td>
                                    {{$schedule->equipment_name}}
                                </td>
                                <td>
                                    {{date('F, j Y', strtotime($schedule->start_date))}}
                                </td>
                                <td>
                                        {{date('F, j Y', strtotime($schedule->end_date))}}
                                    </td>
                                <td>
                                    <form action="{{ route('schedule.destorySchedule', $schedule->id) }}" method="POST" class="schedule_delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"></button>
                                    </form>
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div><!--/.col-6 -->

        {{-- <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="card mt-2">
                    <div class="card-header">
                        <h6 class="text-muted">Equipment Booking:</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-responsive">
                            <thead>
                                <th>Equipment Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($schedules  as $schedule)
                                
                                <tr>
                                    <td>
                                        {{$schedule->equipment_name}}
                                    </td>
                                    <td>
                                        {{date('F, j Y', strtotime($schedule->start_date))}}
                                    </td>
                                    <td>
                                        {{date('F, j Y', strtotime($schedule->end_date))}}
                                    </td>
                                    <td>
                                        <form action="{{ route('schedule.destorySchedule', $schedule->id) }}" method="POST" class="schedule_delete">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div> --}}
            <!--/.col-6 -->

    </div>
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                {!! $schedule_details->calendar() !!}
    
                {!! $schedule_details->script() !!}
        </div>
    </div>


</div><!-- /.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
    
    $(".schedule_delete").on("submit", function(){
    return confirm("Are you sure?");
    });
    $('.select2-multi').select2();
    $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
 });
</script>
@endsection