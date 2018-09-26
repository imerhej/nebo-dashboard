@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager']) 
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Project Settings</h2>
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
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="card mt-2">
                <div class="card-header">
                    <label for="">Input Rates</label>
                </div>
                <div class="card-body">
                    
                    {!! Form::model($rate, ['route' => ['projects.editrates', $rate->id], 'method' => 'PUT']) !!}
                        
                        <input type="hidden" name="project_id" value="{{$project}}">
                    <div class="form-group">
                        <label for="">Truck:</label>
                        <input type="number" name="truck" value="{{$rate->truck}}"  class="form-control" step=".01" required>
                    </div>
                    <div class="form-group">
                        <label for="">Van:</label>
                        <input type="number" name="van" value="{{$rate->van}}" class="form-control" step=".01" required>
                    </div>
                    <div class="form-group">
                        <label for="">Fuel:</label>
                        <input type="number" name="fuel" value="{{$rate->fuel}}" class="form-control" step=".01" required>
                    </div>
                    <div class="form-group">
                        <label for="">Materials:</label>
                        <input type="number" name="material" value="{{$rate->material}}" class="form-control" step=".01" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                    </div>
                   
                    {!! Form::close() !!}  
                
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endrole
@endsection