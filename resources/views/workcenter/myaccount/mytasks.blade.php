@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">My Tasks</h2>
    </div>
</header>
{{-- <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-3 col-sm-3 col-md-3 mt-2 mb-2">
            <a href="{{route('projects.punchtaskhours', $tasklist->project_id)}}" class="btn btn-primary btn-sm mb-2 mt-2">Clock In/Out</a>
        </div>
    </div> --}}

    <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-sm table-responsive mt-2" id="mytable">
                    <thead>

                        <th>Task Name</th>
                        <th>Task Details</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($tasklists as $tasklist)
                        @if (Auth::user()->id == $tasklist->user_id)
                        <tr id="mytasks">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                    value="{{$tasklist->id}}" 
                                   {{ ($tasklist->active == '0') ? 'checked' : ''}}
                                    class="custom-control-input" 
                                    id="{{$tasklist->id}}" disabled>
                                    <label class="custom-control-label" for="{{$tasklist->id}}">{!! $tasklist->tasklistname !!}</label>
                                </div>
                            </td>
                            
                            <td>
                                {!! str_limit($tasklist->tasklistdetails, 40) !!}
                            </td>
                            <td>
                                @if ($tasklist->active == '1')
                                <span class="active-project">Active</span>
                                @elseif ($tasklist->active == '0')
                                <span class="completed-project">Completed</span>
                                @endif
                            </td>
                            <td id="start_date">{{ date('M d Y', strtotime($tasklist->start_date)) }}</td>
                            <td id="end_date">{{ date('M d Y', strtotime($tasklist->end_date)) }}</td>
                            <td>
                                <a href="{{route('projects.showTask', $tasklist->id)}}" title="View" class="btn btn-primary btn-sm fa fa-eye pull-right" id="view"></a>
                            </td>
                            {{-- @role(['superadministrator', 'administrator', 'manager', 'supervisor'])
                            <td>
                                <form action="{{ route('projects.tasklists', $tasklist->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id" value="{{$tasklist->id}}">
                                    <button type="submit" class="btn btn-success btn-sm fa fa-check pull-right" title="Check"></button>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('projects.tasklistfiles', $tasklist->id)}}" class="btn btn-secondary btn-sm fa fa-upload"></a>
                            </td>
                            @endrole
                            @role(['superadministrator', 'administrator'])
                            <td>
                                <a href="{{route('projects.editTasklist', $tasklist->id)}}" title="Edit" class="btn btn-primary btn-sm fa fa-edit pull-right"></a>
                            </td>
                            <td>
                                <form action="{{ route('projects.tasklists', $tasklist->id) }}" method="post" class="tasklist_delete">   
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-right" title="Delete"></button>
                                </form>
                            </td>
                            @endrole --}}
                        </tr>
                        @endif
                        {{-- @endforeach --}}
                        @endforeach
                    </tbody>
                </table>
            </div><!--/.col -->
        </div>
        <div class="row bg-white has-shadow mt-2">
            <!-- Calendar -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card mt-2">
                    <div class="card-body">
                            {!! $tasklistEvent->calendar() !!}
                            {!! $myRtoEvent->calendar() !!}

                            {!! $tasklistEvent->script() !!}
                            {!! $myRtoEvent->script() !!}
                    </div>
                </div>
                    
            </div>
        </div>
</div><!--/.container-fluid -->
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        // var rowCount = $("#mytable > tbody").children().length;

        var start_date = $('#start_date').html();
        var end_date = $('#end_date').html();
        
        // var a = new Date(start_date).toDateString(); 
        var today = $.datepicker.formatDate( "M dd yy", new Date());
        // var T = $.datepicker.formatDate( "M dd yy", new Date());
        // var tomorrow = today.setDate(today.getDate() + 1);

        // var d = new Date().getTime();
        //    var s = d.setDate(d.getDate() + 1);

        // console.log(start_date);
        // var A = new Date(start_date).toDateString();
        
        // $('tr.mytasks').each(function () {
        //     // alert($(this).text($('#start_date').html()));
        //     var s = $(this).append($('#start_date').html());
            
        // }); 

        // $('#mytable').find('#start_date').each(function() {
        //     var s = $(this).text();
            
            
        // });
        // if (start_date == today ) {
        //     $('#mytasks').css('display', 'none');
        //     return false;
        // }
        //  else if (end_date < today)
        // {
        //     $('#mytasks').css('display', 'none');
        // }
        // alert(start_date);
    });
</script>
@endsection