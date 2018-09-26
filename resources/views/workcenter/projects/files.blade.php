@extends('layouts.workcenterlayout')

@section('content')
<div class="modal fade" id="file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Files</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => ['projects.files', $project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div class="form-group">
                    {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'File Name']) }}
                </div>

                <div class="form-group">
                    {{ Form::file('project_file', ['class' => 'form-control', 'required' => '']) }}
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Upload File</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div><!--/.modal -->
    
    <div class="container-fluid">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="h4 no-margin-bottom"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> </h2> 
                <span class="text-muted">Files</span>
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
    <!-- Files section -->
    <section class="tasklists no-padding-bottom">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">
                        <button type="button" class="btn btn-primary fa fa-plus-circle mb-2" data-toggle="modal" data-target="#file" data-whatever="@mdo"> Add Files</button>
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
    </section><!--/.Files Section -->

    <section class="files-list no-padding-bottom">
        <div class="row bg-white has-shadow mt-2 justify-content-md-center">
            <div class="col-lg-8">
                    <table class="table table-responsive">
                            <thead>
                                <th>Name</th>
                                <th>File</th>
                                <th>Uploaded by</th>
                                <th>Created At</th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($files as $file)
                                <tr>
                                    <td>{!! $file->description !!}</td>
                                    <td>{!! $file->project_file !!}</td>
                                    <td>
                                        @foreach ($file->users as $user)
                                        {{$user->firstName}} {{$user->lastName}}
                                        @endforeach
                                    </td>
                                    <td>{!! date('F j Y', strtotime($file->created_at)) !!}</td>
                                    <td>
                                        <a href="/storage/documents/{{($file->project_file)}}" target="_blank" class="btn btn-primary btn-sm fa fa-download pull-right"></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('projects.files', $file->id) }}" method="post" class="file_delete">   
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o pull-left"></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
            </div><!--/.col -->
        </div><!--/.row -->
    </section><!--/.files-list -->

    

</div><!--/.container-fluid -->
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(".file_delete").on("submit", function(){
    return confirm("Are you sure?");
    });   
 });

</script>
@endsection