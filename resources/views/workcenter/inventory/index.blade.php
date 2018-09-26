@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Inventory</h2>
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
                <a href="{{route('inventory.create')}}" class="btn btn-primary btn-sm fa fa-plus-circle mb-2 mt-2"> New Inventory</a>
            </div>
        </div>
    </div>    
</div><!--/.row -->

<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <table class="table table-sm table-responsive mt-2">
            <thead>
                <th>Name</th>
                <th>Model</th>
                <th>Quantity</th>
                <th>Project</th>
                <th>Notes</th>
                <th></th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                <tr>
                    <td>{{$inventory->name}}</td>
                    <td>{{$inventory->model}}</td>
                    <td>{{$inventory->quantity}}</td>
                    <td>{{$inventory->name}}</td>
                    <td>{{$inventory->notes}}</td>
                    <td>
                        <a href="{{route('inventory.show', $inventory->id)}}" class="btn btn-primary btn-sm fa fa-eye" title="view"></a>
                    </td>
                    <td>
                        <a href="{{route('inventory.edit', $inventory->id)}}" class="btn btn-success btn-sm fa fa-edit" title="edit"></a>
                    </td>
                    <td>
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="post" class="inventory_delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o" title="delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <span class="mb-4">{{$inventories->links()}}</span>
    </div>
</div><!--/.row -->
</div><!--/.container-fluid -->
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".inventory_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection