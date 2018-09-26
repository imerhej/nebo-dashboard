@extends('layouts.workcenterlayout')

@section('content')

<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-9 col-sm-9 col-md-9">
                    <h2 class="no-margin-bottom">Workcenter Dashboard</h2>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                        <h6 class="text-muted"> @{{ dateTimeString }}</h6>
                </div>
            </div>
        </div>
    </header>
    @role(['superadministrator'])        
    <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-6 col-sm-6 col-md-6">
            @foreach ($projectbudgets as $projectbudget)
            @foreach ($projects as $project)
            {{-- @if ($projectbudget->project_id == $project->id) --}}
            
                <a href="{{route('projects.show', $project->id)}}">
                    <div id="{{$project->projectName}}"></div>
                </a>
            
            {{-- @endif --}}
            @endforeach
            @endforeach
        </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="card mt-2">
                        {!! $scheduledetails->calendar() !!}
                </div>
            </div>
    </div>
    @endrole
</div><!--/.container-fluid -->

@endsection
@section('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
{!! $scheduledetails->script() !!}
<script>
    var app = new Vue({
        el: '#app',
        data () {
            return {
                dateTimeString: ''
            }
        },
        created () {
            this.dateTimeString = moment().format('MMMM Do YYYY, h:mm:ss a');;

            setInterval(() => {
                this.dateTimeString = moment().format('MMMM Do YYYY, h:mm:ss a');
            }, 1000)
        }
    });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
@role(['superadministrator'])
  google.charts.load("current", {packages:["corechart"]});
  @foreach($budgets as $project)
  google.charts.setOnLoadCallback(project{{$project->id}});
  
  function project{{$project->id}}() {
    
    var data = google.visualization.arrayToDataTable([
      ['Projects', 'Of the month'],
      
      ['Hours', {{$project->total_hours}}],
      ['Facility Management', {{$project->total_facility_management}}],
      ['Margin', {{$project->total_margin}}],
      ['Quote Time', {{$project->total_quote_time}}],
      ['Project Management', {{$project->total_project_management}}],
      ['Travel', {{$project->total_travel}}],
      ['Truck', {{$project->total_truck}}],
      ['Van', {{$project->total_van}}],
      ['Fuel', {{$project->total_fuel}}],
      ['Hotel', {{$project->total_hotel}}],
      ['Perdiem', {{$project->total_perdiem}}],
      ['Materials', {{$project->total_material}}],
      ['Receiving', {{$project->total_receiving}}],
      ['Returns', {{$project->total_return}}],
      
    ]);

    var options = {
      title: '{{$project->projectName}}',
      is3D: true,
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('{{$project->projectName}}'));
    chart.draw(data, options);
    
  }
  @endforeach
  @endrole
</script>

@endsection