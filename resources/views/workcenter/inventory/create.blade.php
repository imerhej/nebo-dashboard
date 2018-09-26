@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Add Inventory</h2>
    </div>
</header>

<div class="row bg-white has-shadow mt-2 ">
    <div class="col-xs-6 col-sm-6 col-md-6 mt-2">
        <div class="card">
            <div class="card-header">
                <span>Add Inventory</span>
            </div><!--/.card-header -->
            <div class="card-body">
                <form action="{{route('inventory.store')}}" method="POST">
                    {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" name="model" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="text" name="quantity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea name="notes" id="" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                </div>
            </form>
            </div><!--/.card-body -->
        </div><!--/.card -->
    </div><!--/.col -->
</div><!--/.row -->
</div><!--/.container-fluid -->
@endsection