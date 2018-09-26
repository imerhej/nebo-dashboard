@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Warning Message-->
    <div class="row mt-2">
            <div class="container-fluid">
                @if (session('warning'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('warning') }}
                    </div>
                @endif
            </div>
        </div>
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
        <h2 class="no-margin-bottom">Punch Hours: </h2> 
        </div>
    </header>
    <div class="row bg-white has-shadow mt-2">
        <div class="col-12 mt-2">
            <form  action="{{route('projects.punchhours', $project->id)}}" method="POST">
                        {{ csrf_field() }}
                @foreach ($project->users as $user)
                <input type="hidden" name="user_id" value="{{$user->id}}">
                @endforeach
                <input type="hidden" name="project_id" value="{{$project->id}}">
                @foreach ($project->tasklist as $tasklist)
                    <input type="hidden" name="tasklist_id" value="{{$tasklist->id}}">
                @endforeach
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="travel" class="col-form-label">Travel Time:</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="travelIn" id="travelIn" value="travelIn">
                                    <label class="custom-control-label" for="travelIn">In</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="travelOut" id="travelOut" value="travelOut">
                                    <label class="custom-control-label" for="travelOut">Out</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="travel" class="col-form-label">Installation Time:</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="installIn" id="installIn" value="installIn">
                                    <label class="custom-control-label" for="installIn">In</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="installOut" id="installOut" value="installOut">
                                    <label class="custom-control-label" for="installOut">Out</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="overtime" class="col-form-label">Over Time:</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="overtimeIn" id="overtimeIn" value="overtimeIn">
                                    <label class="custom-control-label" for="overtimeIn">In</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="overtimeOut" id="overtimeOut" value="overtimeOut">
                                    <label class="custom-control-label" for="overtimeOut">Out</label>
                                </div>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-success btn-sm mb-2 ml-3">Clock In/Out</button>
                </div>

            </form>
            </div>
        </div>
        <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-9 col-sm-9 col-md-9 mt-2">
                <p class="text-muted h5">Clock In/Out Summary: </p>
                {{-- @foreach ($punchhours as $hours)

                <p class="text-muted h6">Travel Time In: {{date('F j Y h:i:s a', strtotime($hours->travelIn))}}</p>
                <p class="text-muted h6">Travel Time Out: {{date('F j Y h:i:s a', strtotime($hours->travelOut))}}</p>
                <p class="text-muted h6">Installation Time In: {{date('F j Y h:i:s a', strtotime($hours->installIn))}}</p>
                <p class="text-muted h6">Installation Time Out: {{date('F j Y h:i:s a', strtotime($hours->installOut))}}</p>
                <p class="text-muted h6">Over Time In: {{date('F j Y h:i:s a', strtotime($hours->overtimeIn))}}</p>
                
                @if (date('F j Y h:i:s a', strtotime($hours->overtimeOut)) !== null)
                <p class="text-muted h6">Over Time Out: {{date('F j Y h:i:s a', strtotime($hours->overtimeOut))}}</p>
                @elseif (date('F j Y h:i:s a', strtotime($hours->overtimeOut)) === '0000-00-00 00:00:00:')
                <p class="text-muted h6">Over Time Out: {{date('F j Y h:i:s a', strtotime($hours->overtimeOut))}}</p>
                @endif
                @endforeach --}}
                {{-- <p class="text-muted h6">Clock In/Out Summary:</p> --}}
            </div>
        </div> 
</div><!--/.container-fluid -->
@endsection
@section('scripts')
<script>

</script>
@endsection