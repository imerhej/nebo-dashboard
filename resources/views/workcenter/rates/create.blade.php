@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Add Rates</h2>
    </div>
</header>
@foreach($errors->all() as $message)
<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    {{ $message }}
</div>
@endforeach
<div class="row bg-white has-shadow mt-2 ">
    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
        <div class="card">
            <div class="card-header">
                <span>New Rates</span>
            </div><!--/.card-header -->
            <div class="card-body">
                <form action="{{route('rates.store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="facility_management">Hour:</label>
                                <input type="number" name="hour" class="form-control" step=".01" min="0">
                            </div> 
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="facility_management">Facility Management:</label>
                                <input type="number" name="facility_management" class="form-control" step=".01" min="0">
                            </div> 
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="model">Margin:</label>
                                <input type="number" name="margin" class="form-control" step=".01" min="0">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="quote_time">Quote Time:</label>
                                <input type="number" name="quote_time" class="form-control" step=".01"  min="0">
                            </div>
                        </div>
                        
                    </div><!--/.row -->

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="travel">Travel:</label>
                                <input type="number" name="travel" class="form-control" step=".01" min="0">
                            </div> 
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="truck">Truck:</label>
                                <input type="number" name="truck" class="form-control" step=".01" min="0">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="van">Van:</label>
                                <input type="number" name="van" class="form-control" step=".01"  min="0">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="fuel">Fuel:</label>
                                <input type="number" name="fuel" class="form-control" step=".01"  min="0">
                            </div>
                        </div>
                    </div><!--/.row -->

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="hotel">Hotel:</label>
                                <input type="number" name="hotel" class="form-control" step=".01" min="0">
                            </div> 
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="perdiem">Perdiem:</label>
                                <input type="number" name="perdiem" class="form-control" step=".01" min="0">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="material">Mterial:</label>
                                <input type="number" name="material" class="form-control" step=".01"  min="0">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="project_management	">Project Management:</label>
                                <input type="number" name="project_management" class="form-control" step=".01" min="0" >
                            </div>
                        </div>
                    </div><!--/.row -->

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="return">Inventory/Return:</label>
                                <input type="number" name="return" class="form-control" step=".01" size="3" min="0">
                            </div> 
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="receiving">Receiving:</label>
                                    <input type="number" name="receiving" class="form-control" step=".01"  min="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                {{-- <label for="material">Mterial:</label>
                                <input type="number" name="material" class="form-control" step=".01"  > --}}
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary btn-sm pull-right mt-4">Submit</button>
                            </div>
                        </div>
                    </div><!--/.row -->
                </form>
            </div><!--/.card-body -->
        </div><!--/.card -->
    </div><!--/.col -->
</div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection