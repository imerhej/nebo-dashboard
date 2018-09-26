@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager', 'manager', 'supervisor'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
        <h2 class="h4 no-margin-bottom"> {{$tasklist->tasklistname}}</h2>
        </div>
    </header>

    <div class="row bg-white has-shadow mt-2 justify-content-md-center">
        <div class="col-md-8">
            <div class="card mt-2">
                    <div class="card-header">
                        <strong>Tasklist Details:</strong>   
                    </div><!-- /.card-header -->
                <div class="card-body">
                    {!! Form::model($tasklist, ['route' => ['projects.editTasklist', $tasklist->id], 'method' => 'PUT']) !!}
                        <input type="hidden" name="project_id" value="{{$projectId}}">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="tasklistname" value="{{$tasklist->tasklistname}}" class="form-control" placeholder="Task list name" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea name="tasklistdetails" class="form-control" placeholder="Task list details" rows="3">{{$tasklist->tasklistdetails}}</textarea>
                        </div>      
                    </div>
                </div>
      
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                                <label for="select-users" class="text-muted">- Select Employees -</label>
                            {{ Form::select('users[]', $users, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple', 'required' => 'required'])}}
                        </div> 
                    </div>
                </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                            <input type="text" name="start_date" value="{{$tasklist->start_date}}" id="start_date" class="form-control" placeholder="Start Date" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" name="end_date" value="{{$tasklist->end_date}}" id="end_date" class="form-control" placeholder="End Date" required>
                            </div>
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="milestone_id" id="" class="form-control" >
                                    <option value="">- Milestone -</option>
                                    @foreach($milestones as $milestone)
                                        {{-- @foreach($tasklist->milestones as $tasklistMilestone) --}}
                                            <option value="{{$milestone->id}}" {{$tasklist->milestone_id == $milestone->id ? 'selected' : ''}}>{{$milestone->milestoneName}}</option>
                                        {{-- @endforeach --}}
                                    @endforeach
                                </select>
                            </div>       
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="color" id="color" class="form-control" required>
                                    <option value=""> - Select Color -</option>
                                    @foreach ($colors as $color)
                                    <option value="{{$color->value}}" style="{{$color->style}}" {{$tasklist->color == $color->value ? 'selected' : ''}}>{{$color->name}}</option>
                                     @endforeach
                                </select>
                            </div>   
                        </div>
                    </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="active" name="active" value="1" {{ ($tasklist->active == 1) ? 'checked' : '' }} class="custom-control-input">
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="completed" name="active" value="0" {{ ($tasklist->active == 0) ? 'checked' : '' }} class="custom-control-input">
                                    <label class="custom-control-label" for="completed">Completed</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                            <button type="submit" class="btn btn-primary pull-right mb-3">Update Task</button>
                    </div>
                </div>
                
            </div>
            
            {!! Form::close() !!} 
                </div><!--/.card-body -->
            </div><!--/.card -->
                
        </div>
    </div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".tasklist_delete").on("submit", function(){
        return confirm("Are you sure?");
    });
    
    $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('.select2-multi').select2();
 });
</script>
@endsection