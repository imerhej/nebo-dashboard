@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])           
<div class="container-fluid">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="modal fade" id="addRates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="{{route('projects.projectbudget', $project->id)}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <table class="table table-sm table-responsive mt-2">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Labor Hours</th>
                            <th scope="col">F&M Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $rate)
                            <tr>
                                <th scope="row">Total Hours</th>
                                <td><input type="number" name="input_hour" id="" step=".01" size="2"></td>
                                <td><input type="number" name="hour" value="{{$rate->hour}}" id="" disabled></td>
                            </tr>

                            <tr>
                                <th scope="row">Facility Management</th>
                                <td><input type="number" name="input_facility_management" id="" step=".01" size="2" min="0"></td>
                                <td><input type="number" name="facility_management" value="{{$rate->facility_management}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Margin</th>
                                <td><input type="number" name="input_margin" id="" step=".01" min="0"></td>
                                <td><input type="number" name="margin" value="{{$rate->margin}}" id="" disabled></td>
                            </tr>

                            <tr>
                                <th scope="row">Quote Time</th>
                                <td><input type="number" name="input_quote_time" id="" step=".01" min="0"></td>
                                <td><input type="number" name="quote_time" value="{{$rate->quote_time}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Project Management</th>
                                <td><input type="number" name="input_project_management" id="" step=".01" min="0"></td>
                                <td><input type="number" name="project_management" value="{{$rate->project_management}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Travel</th>
                                <td><input type="number" name="input_travel" id="" step=".01" min="0"></td>
                                <td><input type="number" name="travel" value="{{$rate->travel}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Truck</th>
                                <td><input type="number" name="input_truck" id="" step=".01" min="0"></td>
                                <td><input type="number" name="truck" value="{{$rate->truck}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Van</th>
                                <td><input type="number" name="input_van" id="" step=".01" min="0"></td>
                                <td><input type="number" name="van" value="{{$rate->van}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Fuel</th>
                                <td><input type="number" name="input_fuel" id="" step=".01" min="0"></td>
                                <td><input type="number" name="fuel" value="{{$rate->fuel}}" id="" disabled></td>
                            </tr>

                            <tr>
                                <th scope="row">Hotel</th>
                                <td><input type="number" name="input_hotel" id="" step=".01" min="0"></td>
                                <td><input type="number" name="hotel" value="{{$rate->hotel}}" id="" disabled></td>
                            </tr>

                            <tr>
                                <th scope="row">Perdiem</th>
                                <td><input type="number" name="input_perdiem" id="" step=".01" min="0"></td>
                                <td><input type="number" name="perdiem" value="{{$rate->perdiem}}" id="" disabled></td>
                            </tr>

                            <tr>
                                <th scope="row">Materials</th>
                                <td><input type="number" name="input_material" id="" step=".01" min="0"></td>
                                <td><input type="number" name="material" value="{{$rate->material}}" id="" disabled></td>
                             </tr>

                            <tr>
                                <th scope="row">Receiving</th>
                                <td><input type="number" name="input_receiving" id="" step=".01" min="0"></td>
                                <td><input type="number" name="receiving" value="{{$rate->receiving}}" id="" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Inventory/Return</th>
                                <td><input type="number" name="input_return" id="" step=".01" min="0"></td>
                                <td><input type="number" name="return" value="{{$rate->return}}" id="" disabled></td>
                            </tr>                                    
                            @endforeach                                 
                        </tbody>
                    </table>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <input type="submit" id="addrates1" class="btn btn-primary btn-sm"></input>
        </div>
        </div>
    </form>
    </div>
</div> 
</div> <!--/.modal -->
<div class="modal fade" id="truckSchedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form action="{{route('inventory.schedule', $project->id)}}" method="POST">
                        {{ csrf_field() }}
            <input type="hidden" name="project_id" value="{{$project->id}}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Truck Schedule/Equipment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="text" name="start_date" class="form-control" id="start_date" placeholder="Start Date" required>
                    </div>
                </div>
                <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="end_date" class="form-control" id="end_date" placeholder="End Date" required>
                        </div>
                    </div>
                
              </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <select name="inventory_id" id="" class="form-control" required>
                                <option value="">- Select Equipment -</option>
                                @foreach ($availableInventory as $inventory)
                                <option value="{{$inventory->id}}">{{$inventory->name}} - Available {{$inventory->quantity}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <input type="text" name="quantity" class="form-control" id="quantity" placeholder="Quantity" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Notes:</label>
                            <textarea name="notes" class="form-control" id="message-text"></textarea>
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
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom"> <a href="{{route('projects.show', $project->id)}}">{{$project->projectName}} Rates & Budget</a> </h5>
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
    @foreach($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        {{ $message }}
    </div>
    @endforeach
    <!-- Charts -->
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div id="piechart_3d"></div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
                <div id="piechart_3d2"></div>
        </div>
    </div>
    <!--Rates -->
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-8 col-sm-8 col-md-8">
                
                    <div class="card mt-2">
                        <div class="card-header">
                            <label for="">Input Rates</label>
                        </div>
                        <div class="card-body">
                            
                            <button type="button" id="addrates" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRates" data-whatever="@mdo">Add Rates</button>
                            {{-- <a href="{{route('projects.updateprojectrates', $project->id)}}" class="btn btn-success btn-sm">Edit Rates</a> --}}
                            @foreach ($input_rates as $input_rate)
                            <form action="{{route('projects.projectbudget', $input_rate->id)}}" method="POST" id="form">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                <input type="hidden" name="project_id" value="{{$project->id}}">
                             @endforeach   
                            <table class="table table-sm table-responsive mt-2">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Labor Hours</th>
                                    <th scope="col">F&M Hours</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Punch Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rates as $rate)
                                    @foreach ($input_rates as $input_rate)
                                    @foreach ($projectBudget as $total)
                                    <tr>
                                        <th scope="row">Total Hours</th>
                                        <td><input type="number" name="input_hour" value="{{$input_rate->input_hour}}" id="" step=".01" size="2" min="0"></td>
                                        <td><input type="number" name="hour" value="{{$rate->hour}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_hours}}" id="" disabled></td>
                                        <td>{{$officialTime}} &equals; {{$sumofhours}}</td>                                        
                                    </tr>
                                    <tr>
                                        <th scope="row">Facility Management</th>
                                        <td><input type="number" name="input_facility_management" value="{{$input_rate->input_facility_management}}" id="" step=".01" size="2" min="0"></td>
                                        <td><input type="number" name="facility_management" value="{{$rate->facility_management}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_facility_management}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Margin</th>
                                        <td><input type="number" name="input_margin" value="{{$input_rate->input_margin}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="margin" value="{{$rate->margin}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_margin}}" disabled></td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Quote Time</th>
                                        <td><input type="number" name="input_quote_time" value="{{$input_rate->input_quote_time}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="quote_time" value="{{$rate->quote_time}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_quote_time}}" disabled ></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Project Management</th>
                                        <td><input type="number" name="input_project_management" value="{{$input_rate->input_project_management}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="project_management" value="{{$rate->project_management}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_project_management}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Travel</th>
                                        <td><input type="number" name="input_travel" value="{{$input_rate->input_travel}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="travel" value="{{$rate->travel}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_travel}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Truck</th>
                                        <td><input type="number" name="input_truck" value="{{$input_rate->input_truck}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="truck" value="{{$rate->truck}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_truck}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Van</th>
                                        <td><input type="number" name="input_van" value="{{$input_rate->input_van}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="van" value="{{$rate->van}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_van}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fuel</th>
                                        <td><input type="number" name="input_fuel" value="{{$input_rate->input_fuel}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="fuel" value="{{$rate->fuel}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_fuel}}" disabled></td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Hotel</th>
                                        <td><input type="number" name="input_hotel" value="{{$input_rate->input_hotel}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="hotel" value="{{$rate->hotel}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_hotel}}" disabled></td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Perdiem</th>
                                        <td><input type="number" name="input_perdiem" value="{{$input_rate->input_perdiem}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="perdiem" value="{{$rate->perdiem}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_perdiem}}" disabled></td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Materials</th>
                                        <td><input type="number" name="input_material" value="{{$input_rate->input_material}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="material" value="{{$rate->material}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_material}}" disabled></td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Receiving</th>
                                        <td><input type="number" name="input_receiving" value="{{$input_rate->input_receiving}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="receiving" value="{{$rate->receiving}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_receiving}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Inventory/Return</th>
                                        <td><input type="number" name="input_return" value="{{$input_rate->input_return}}" id="" step=".01" min="0"></td>
                                        <td><input type="number" name="return" value="{{$rate->return}}" id="" disabled></td>
                                        <td><input type="number" name="" value="{{$total->total_return}}" disabled></td>
                                        <td>
                                            @foreach ($sum as $total)
                                                <span class="h6">Total:</span> <span class="h6 text-muted mt-2">{{$total->total}}</span>
                                            @endforeach
                                        </td>
                                    </tr>                                    
                                    @endforeach 
                                    @endforeach
                                    @endforeach                                     
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success btn-sm mb-2" id="update">Update</button>
                        </form>
                        </div><!--/.card-body -->

                    </div><!--/.card -->
               
        </div><!--/.col-8 -->
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#truckSchedule" data-whatever="@getbootstrap">Truck Schedule/Equipment</button>
                </div><!--/.card-header-->
                <div class="card-body">
                    <table class="table table-sm table-responsive">
                        <thead>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($equipments as $equipment)
                            @foreach ($inventories as $inventory)
                            @if ($inventory->id == $equipment->inventory_id)
                            <tr>
                                <td>{{$inventory->name}}</td>
                                <td>{{$equipment->quantity}}</td>
                                <td>{{date('F j Y', strtotime($equipment->start_date))}}</td>
                                <td>{{date('F j Y', strtotime($equipment->end_date))}}</td>
                                <td><a href="{{ route('inventory.schedule', $equipment->id) }}" class="btn btn-primary btn-sm fa fa-eye"></a></td>
                                <td>
                                    <form action="{{ route('inventory.schedule', $equipment->id) }}" method="post" class="equipment_delete">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o "></button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    
                        
                    
                </div><!--/.card-body-->
            </div><!--/.card-->
        </div><!--/.col-4-->
    </div><!--/.row -->
</div><!-- /.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
      var b = $('.card-body').has('#form').length ? "yes" : "no";
      if ( b == "yes") {
        $("#addrates").hide();
        $("#addrates1").hide();
        $("#update").show();
      } else if ( b == "no") {
        $("#addrates").show();
        $("#addrates1").show();
        $("#update").hide();
      }

      $('#addrates1').attr('disabled','disabled');
        $('input[type="number"]').keyup(function() {
        if($(this).val() != '') {
           $('input[type="submit"]').removeAttr('disabled');
        } else if($(this).val() == '') {
            $('input[type="submit"]').attr('disabled', 'disabled');
        }
     });
     $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $(".equipment_delete").on("submit", function(){
    return confirm("Are you sure?");
    });
    })
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Projects', 'Of the month'],
      @foreach($projectBudget as $project)
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
      @endforeach
    ]);

    var options = {
      title: 'Project Total Expenses',
      is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
    chart.draw(data, options);
  }
</script>
 <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        @foreach($input_rates as $rate)
        ['Hour', {{$rate->input_hour}}],
        ['Facility Management', {{$rate->input_facility_management}}],
        ['Margin', {{$rate->input_margin}}],
        ['Quote Time', {{$rate->input_quote_time}}],
        ['Project Management', {{$rate->input_project_management}}],
        ['Travel', {{$rate->input_travel}}],
        ['Truck', {{$rate->input_truck}}],
        ['Van', {{$rate->input_van}}],
        ['Fuel', {{$rate->input_fuel}}],
        ['Hotel', {{$rate->input_hotel}}],
        ['Perdiem', {{$rate->input_perdiem}}],
        ['Material', {{$rate->input_material}}],
        ['Receiving', {{$rate->input_receiving}}],
        ['Return', {{$rate->input_return}}],
        @endforeach
      ]);

      var options = {
        title: 'Project Individual Rate Expenses',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));
      chart.draw(data, options);
    }
  </script>
@endsection