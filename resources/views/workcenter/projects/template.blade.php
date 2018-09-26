@extends('layouts.workcenterlayout')

@section('content')
           
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Project Rates</h2>
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
        <div class="col-3">
            
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection