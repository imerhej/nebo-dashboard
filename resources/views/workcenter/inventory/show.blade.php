@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"> <a href="{{route('inventory.index')}}">Inventory</a> </h2>
    </div>
</header>
<div class="row bg-white has-shadow mt-2">
    <!-- Item -->
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="item d-flex">
            <div class="title">
                <a href="{{route('inventory.edit', $inventory->id)}}" class="btn btn-primary btn-sm fa fa-edit mb-2 mt-2"> Edit Inventory</a>
            </div>
        </div>
    </div>    
</div><!--/.row -->

<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card mt-2">
            <div class="card-header">
                <span>{{$inventory->name}} Inventory</span>
            </div><!--/.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name: {{$inventory->name}}</label>
                </div>
                <div class="form-group">
                    <label for="model">Model: {{$inventory->model}}</label>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity: {{$inventory->quantity}}</label>
                </div>
                <div class="form-group">
                    <label for="notes">Notes: {{$inventory->notes}}</label>
                </div>
            </div><!--/.card-body -->
        </div><!--/.card -->
    </div>
</div><!--/.row -->
</div><!--/.container-fluid -->
@endsection