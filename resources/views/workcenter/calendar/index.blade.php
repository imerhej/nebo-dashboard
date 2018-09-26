@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Projects Calendar</h2>
        </div>
    </header>
    <div class="row bg-white has-shadow mt-2">
        <div class="col-xs-12 col-sm-12 col-md-12"> 
            <section class="section">
                    {!! $project_details->calendar() !!}
            </section>
        </div>
    </div><!--/.row -->
</div><!-- /.container-fluid -->
    {!! $project_details->script() !!}
@endsection