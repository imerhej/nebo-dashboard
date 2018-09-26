@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Project Rates</h2>
    </div>
</header>

<!-- Success Message -->
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
    <!-- Item -->
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="item d-flex">
            <div class="title">
                <a href="{{route('rates.edit', $rate->id)}}" class="btn btn-primary btn-sm fa fa-plus-circle mb-2 mt-2"> Edit Rates</a>
            </div>
        </div>
    </div>    
</div><!--/.row -->

<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card-body">

                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                        <label for="facility_management">Hour:</label> <span class="text-muted">{{$rate->hour}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="facility_management">Facility Management:</label> <span class="text-muted">{{$rate->facility_management}}</span>
                                </div> 
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="model">Margin:</label> <span class="text-muted">{{$rate->margin}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="quote_time">Quote Time:</label> <span class="text-muted">{{$rate->quote_time}}</span>
                                </div>
                            </div>
                            
                        </div><!--/.row -->
    
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="travel">Travel:</label> <span class="text-muted">{{$rate->travel}}</span>
                                </div> 
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="truck">Truck:</label> <span class="text-muted">{{$rate->truck}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="van">Van:</label> <span class="text-muted">{{$rate->van}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="fuel">Fuel:</label> <span class="text-muted">{{$rate->fuel}}</span>
                                </div>
                            </div>
                        </div><!--/.row -->
    
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="hotel">Hotel:</label> <span class="text-muted">{{$rate->hotel}}</span>
                                </div> 
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="perdiem">Perdiem:</label> <span class="text-muted">{{$rate->perdiem}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="material">Mterial:</label> <span class="text-muted">{{$rate->material}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <label for="project_management	">Project Management:</label> <span class="text-muted">{{$rate->project_management}}</span>
                            </div>
                        </div><!--/.row -->
    
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="return">Inventory/Return:</label> <span class="text-muted">{{$rate->return}}</span>
                                </div> 
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="receiving">Receiving:</label> <span class="text-muted">{{$rate->receiving}}</span>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                               
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group mt-2">
                                    
                                </div>
                            </div>
                        </div><!--/.row -->
                    </form>
                </div><!--/.card-body -->
            </div><!--/.card -->
    </div>
</div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection
