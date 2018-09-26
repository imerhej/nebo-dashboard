@extends('layouts.workcenterlayout')

@section('content')
<div class="modal fade" id="milestone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Assign new milestone</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form  action="{{route('projects.milestones', $project->id)}}" method="POST">
                        {{ csrf_field() }}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="form-group">
                    <input type="text" name="milestoneName" class="form-control" placeholder="Milestone name" required>
                </div>

                <div class="form-group">
                    <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date" required>
                </div>
                <div class="form-group">
                    <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" required>
                </div>
      
                <div class="form-group">
                    <textarea name="description" class="form-control" placeholder="Milestone details" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <select name="color" id="color" class="form-control" required>
                        <option value=""> - Select Color -</option>
                        @foreach ($colors as $color)
                        <option value="{{$color->value}}" style="{{$color->style}}">{{$color->name}}</option>
                        @endforeach
                    </select>
                </div>

              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Milestone</button>
            </div>
            </form>
          </div>
        </div>
    </div><!--/.modal -->
    
    <div class="container-fluid">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="h4 no-margin-bottom"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> </h2> 
                <span class="text-muted">Milestones</span>
            </div>
        </header>
        <!-- Success Message -->
        <div class="row mt-2">
            <div class="container">
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
    <!-- Tasklist section -->
    <section class="tasklists no-padding-bottom">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">
                        <button type="button" class="btn btn-primary fa fa-plus-circle mb-2" data-toggle="modal" data-target="#milestone" data-whatever="@mdo"> New Milestone</button>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-4 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">

                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-5 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">
                        
                    </div>
                </div>
            </div>
        </div><!--/.row -->
    </section><!--/.Tasklist Section -->

    <section class="tasklist-details no-padding-botton">
        
        <div class="row bg-white has-shadow">
                @foreach ($milestones as $milestone)
            <div class="col-sm-6">
                <div class="card mt-3">
                    <div class="card-header">
                      <div class="row">
                          <div class="col-md">
                            <label for="" class="h5">{!! $milestone->milestoneName !!}</label>
                          </div>
                          <div class="col-md">
                                @role(['superadministrator', 'administrator', 'manager'])
                            <form action="{{ route('projects.milestones', $milestone->id) }}" method="post" class="milestone_delete">   
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-right"></button>
                                <a href="{{route('projects.editMilestone', $milestone->id)}}" class="btn btn-primary btn-sm fa fa-edit pull-right"></a>
                                @endrole
                            </form>
                          </div>
                      </div>
                        
                    </div>
                    <div class="card-body">   
                    <p class="text-muted">Description: {{str_limit($milestone->description, 50)}}</p>
                        <p class="text-muted">Due Date: {!! date('F j Y', strtotime($milestone->end_date)) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </section><!--/.tasklist-details section -->

</div><!--/.container-fluid -->
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(".milestone_delete").on("submit", function(){
    return confirm("Are you sure?");
    });
    $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    
 });

</script>
@endsection