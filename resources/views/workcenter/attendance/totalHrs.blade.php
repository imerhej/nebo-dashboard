@extends('layouts.workcenterlayout')

@section('content')
           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Total Hours</h5>
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
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            @foreach ($query as $q)
                <span class="h6">Installer Name: {{$q->firstName}} {{$q->lastName}}</span> <br>
            @endforeach
            <span class="h6">From: {{$start}}</span> <br>

            <span class="h6"> To: {{$end}}</span> <br>

            <span class="h6">Total hours: {{round(($totalTime)/3600, 2)}}</span> =  <span class="h5">{{$officialTime}}</span>
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection