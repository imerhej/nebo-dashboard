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
                <a href="{{route('rates.create')}}" class="btn btn-primary btn-sm fa fa-plus-circle mb-2 mt-2"> New Rates</a>
            </div>
        </div>
    </div>    
</div><!--/.row -->

<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <table class="table table-sm table-responsive table-bordered mt-2">
            <thead>
                <th>Hour</th>
                <th>Facility Management</th>
                <th>Margin</th>
                <th>Quote Time</th>
                <th>Project Management</th>
                <th>Travel</th>
                <th>Truck</th>
                <th>Van</th>
                <th>Fuel</th>
                <th>Hotel</th>
                <th>Perdiem</th>
                <th>Material</th>
                <th>Receiving</th>
                <th>Return</th>
                <th></th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($rates as $rate)
                <tr>
                    <td>{{$rate->hour}}</td>
                    <td>{{$rate->facility_management}}</td>
                    <td>{{$rate->margin}}</td>
                    <td>{{$rate->quote_time}}</td>
                    <td>{{$rate->project_management}}</td>
                    <td>{{$rate->travel}}</td>
                    <td>{{$rate->truck}}</td>
                    <td>{{$rate->van}}</td>
                    <td>{{$rate->fuel}}</td>
                    <td>{{$rate->hotel}}</td>
                    <td>{{$rate->perdiem}}</td>
                    <td>{{$rate->material}}</td>
                    <td>{{$rate->receiving}}</td>
                    <td>{{$rate->return}}</td>
                    <td>
                        <a href="{{route('rates.show', $rate->id)}}" class="btn btn-primary btn-sm fa fa-eye" title="view"></a>
                    </td>
                    <td>
                        <a href="{{route('rates.edit', $rate->id)}}" class="btn btn-success btn-sm fa fa-edit" title="edit"></a>
                    </td>
                    <td>
                        <form action="{{ route('rates.destroy', $rate->id) }}" method="post" class="rate_delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o" title="delete"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <span class="mb-4">{{$rates->links()}}</span>
    </div>
</div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".rate_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection