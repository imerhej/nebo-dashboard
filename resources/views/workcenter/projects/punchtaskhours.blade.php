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
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
        <h5 class="no-margin-bottom">Punch Hours: </h5> 
        </div>
    </header>
    @role(['installer'])
    <div class="row bg-white has-shadow mt-2">
        <div class="col-12 mt-2">
            <form  action="{{route('projects.punchtaskhours', $project->id)}}" method="POST">
                        {{ csrf_field() }}
                @foreach ($users as $user)
                @if ($user->id == Auth::user()->id)
                <input type="hidden" name="user_id" value="{{$user->id}}">
                @endif
                
                @endforeach
                <input type="hidden" name="project_id" value="{{$project->id}}">
                {{-- <input type="hidden" name="tasklist_id" value="{{$tasklists->id}}"> --}}
                {{-- @foreach ($tasklists as $tasklist)
                    <input type="hidden" name="tasklist_id" value="{{$tasklist->id}}">
                @endforeach --}}
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
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
                        <div class="col-xs-3 col-sm-3 col-md-3">
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

                        {{-- <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="travel" class="col-form-label">Break Time:</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="breakIn" id="breakIn" value="breakIn">
                                        <label class="custom-control-label" for="breakIn">In</label>
                                    </div>
                                </div>
                                    <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="breakOut" id="breakOut" value="breakOut">
                                        <label class="custom-control-label" for="breakOut">Out</label>
                                    </div>
                                    </div>
                            </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
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
                            </div> --}}
                    {{-- @if (Auth::user()->id === $user->id) --}}
                    <button type="submit" class="btn btn-success btn-sm mb-2 ml-3">Clock In/Out</button>
                    {{-- @endif --}}
                </div>

            </form>
            </div>
        
        </div>
        @endrole
</div><!--/.container-fluid -->
@endsection