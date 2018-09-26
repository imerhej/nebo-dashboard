@extends('layouts.workcenterlayout')

@section('content')
           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom"> <a href="{{route('projects.show', $project->id)}}">{{$project->projectName}} Update Rates & Budget</a> </h5>
        </div>
</header>

    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-8 col-sm-8 col-md-8">
                
                    <div class="card mt-2">
                        <div class="card-header">
                            <label for="">Input Rates</label>
                        </div>
                        <div class="card-body">
                           
                            <form action="{{route('projects.updateprojectrates', $project->id)}}" method="POST">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                <input type="hidden" name="project_id" value="{{$project->id}}">
                                
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
                                    {{-- @foreach($rates as $rate) --}}
                                    @foreach ($input_rates as $input_rate)
                                    {{-- @foreach ($projectBudget as $total) --}}
                                    <tr>
                                        <th scope="row">Facility Management</th>
                                        <td><input type="number" name="input_facility_management" value="{{$input_rate->input_facility_management}}" id="" step=".01" required size="2"></td>
                                        {{-- <td><input type="number" name="facility_management" value="{{$rate->facility_management}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_facility_management}}" disabled></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Margin</th>
                                        <td><input type="number" name="input_margin" value="{{$input_rate->input_margin}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="margin" value="{{$rate->margin}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_margin}}" disabled></td> --}}
                                    </tr>

                                    <tr>
                                        <th scope="row">Quote Time</th>
                                        <td><input type="number" name="input_quote_time" value="{{$input_rate->input_quote_time}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="quote_time" value="{{$rate->quote_time}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_quote_time}}" disabled ></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Project Management</th>
                                        <td><input type="number" name="input_project_management" value="{{$input_rate->input_project_management}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="project_management" value="{{$rate->project_management}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_project_management}}" disabled></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Travel</th>
                                        <td><input type="number" name="input_travel" value="{{$input_rate->input_travel}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="travel" value="{{$rate->travel}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_travel}}" disabled></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Truck</th>
                                        <td><input type="number" name="input_truck" value="{{$input_rate->input_truck}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="truck" value="{{$rate->truck}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_truck}}" disabled></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Van</th>
                                        <td><input type="number" name="input_van" value="{{$input_rate->input_van}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="van" value="{{$rate->van}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_van}}" disabled></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Fuel</th>
                                        <td><input type="number" name="input_fuel" value="{{$input_rate->input_fuel}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="fuel" value="{{$rate->fuel}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_fuel}}" disabled></td> --}}
                                    </tr>

                                    <tr>
                                        <th scope="row">Hotel</th>
                                        <td><input type="number" name="input_hotel" value="{{$input_rate->input_hotel}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="hotel" value="{{$rate->hotel}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_hotel}}" disabled></td> --}}
                                    </tr>

                                    <tr>
                                        <th scope="row">Perdiem</th>
                                        <td><input type="number" name="input_perdiem" value="{{$input_rate->input_perdiem}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="perdiem" value="{{$rate->perdiem}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_perdiem}}" disabled></td> --}}
                                    </tr>

                                    <tr>
                                        <th scope="row">Materials</th>
                                        <td><input type="number" name="input_material" value="{{$input_rate->input_material}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="material" value="{{$rate->material}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_material}}" disabled></td> --}}
                                    </tr>

                                    <tr>
                                        <th scope="row">Receiving</th>
                                        <td><input type="number" name="input_receiving" value="{{$input_rate->input_receiving}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="receiving" value="{{$rate->receiving}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_receiving}}" disabled></td> --}}
                                    </tr>
                                    <tr>
                                        <th scope="row">Inventory/Return</th>
                                        <td><input type="number" name="input_return" value="{{$input_rate->input_return}}" id="" step=".01"></td>
                                        {{-- <td><input type="number" name="return" value="{{$rate->return}}" id="" disabled></td> --}}
                                        {{-- <td><input type="number" name="" value="{{$total->total_return}}" disabled></td> --}}
                                        <td>
                                            @foreach ($sum as $total)
                                                <span class="h4">Total:</span> <span class="h4 text-muted mt-2">{{$total->total}}</span>
                                            @endforeach
                                        </td>
                                    </tr>                                    
                                    {{-- @endforeach  --}}
                                    {{-- @endforeach --}}
                                    @endforeach                                     
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success btn-sm mb-2">Update</button>
                        </form>
                        </div><!--/.card-body -->

                    </div><!--/.card -->
               
        </div><!--/.col-8 -->
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="card mt-2">
                <div class="card-header">
                    <span>Charts</span>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div><!--/.row -->
</div><!-- /.container-fluid -->
@endsection