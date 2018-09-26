@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Update Inventory</h2>
    </div>
</header>

<div class="row bg-white has-shadow mt-2 ">
    <div class="col-xs-6 col-sm-6 col-md-6 mt-2">
        <div class="card">
            <div class="card-header">
                <span>Update Inventory</span>
            </div><!--/.card-header -->
            <div class="card-body">
                <form action="{{route('inventory.update', $inventory->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="{{$inventory->name}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" name="model" value="{{$inventory->model}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="text" name="quantity" value="{{$inventory->quantity}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea name="notes" id="" class="form-control">{{$inventory->notes}}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Save Changes</button>
                </div>
            </form>
            </div><!--/.card-body -->
        </div><!--/.card -->
    </div><!--/.col -->
</div><!--/.row -->
</div><!--/.container-fluid -->
@endsection