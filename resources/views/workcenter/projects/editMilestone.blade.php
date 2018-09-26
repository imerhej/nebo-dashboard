@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="h4 no-margin-bottom">{{$milestone->milestoneName}} </h2> 
            <span class="text-muted">Milestone </span>
        </div>
    </header>

    <section class="milestone-form no-padding-botton">
        <div class="row bg-white has-shadow justify-content-md-center mt-2">
            <div class="col-md-8 mt-3">
                    {!! Form::model($milestone, ['route' => ['projects.editMilestone', $milestone->id], 'method' => 'PUT']) !!}
                            {{ csrf_field() }}
                        <input type="hidden" name="project_id" value="{{$projectId}}">
                    <div class="form-group">
                        <input type="text" name="milestoneName" value="{{$milestone->milestoneName}}" class="form-control" placeholder="Milestone name" required>
                    </div>
    
                    <div class="form-group">
                        <input type="text" name="start_date" value="{{$milestone->start_date}}" id="start_date" class="form-control" placeholder="Start Date" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="end_date" value="{{$milestone->end_date}}" id="end_date" class="form-control" placeholder="End Date" required>
                    </div>
          
                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="Milestone details" rows="3">{{$milestone->description}}</textarea>
                    </div>
    
                    <div class="form-group">
                        <select name="color" id="color" class="form-control" required>
                            <option value=""> - Select Color -</option>
                            @foreach ($colors as $color)
                            <option value="{{$color->value}}" style="{{$color->style}}" {{$milestone->color == $color->value ? 'selected' : ''}} >{{$color->name}}</option>
                            @endforeach
                        </select>
                    </div>
    
                  <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm pull-right mb-3">Save Changes</button>
                </div>   
                {!! Form::close() !!}
            </div>
        </div>
        
    </section><!--/.milstone-form section -->

</div><!--/.container-fluid -->
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        
    $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    
 });

</script>
@endsection