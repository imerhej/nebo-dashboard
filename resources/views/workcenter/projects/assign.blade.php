@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
        {{-- <h2 class="h4 no-margin-bottom"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> </h2> <span class="text-muted">Assign Co-Workers</span> --}}
    </div>
</header>
{{-- <form  action="{{route('projects.assign', $project->id)}}" method="POST"> --}}
        {{-- {{ csrf_field() }} --}}
<div class="row bg-white has-shadow mt-2">
    <div class="col-xs-6 col-sm-6 col-md-">
        <div class="card mt-2">
            <div class="card-header">
                <h5>Available Co-Workers:</h5>
            </div>
            <div class="card-body">
                @foreach ($availableUsers as $available)
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="available" v-model="available">
                    <input type="checkbox" name="available[]" value="{{$available->id}}" v-model="available" class="custom-control-input" id="{{$available->firstName}}">
                    <label class="custom-control-label" for="{{$available->firstName}}">{{$available->firstName}} {{$available->lastName}} - 
                    {{-- @foreach ($available->roles as $role)
                        {{$role->display_name}}
                    @endforeach --}}
                    </label>
                </div>
                @endforeach
            </div>
            {{-- <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Assign Co-Workers</button>
                </div> --}}
        </div>
    </div>
{{-- </form> --}}
    <div class="col-xs-6 col-sm-6 col-md-">
        <div class="card mt-2">
            <div class="card-header">
                <h5>Un-Available Co-Workers:</h5>
            </div>
            <div class="card-body">
                    @foreach ($unavailableUsers as $unavailable)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="available" value="{{$unavailable->id}}"
                         class="custom-control-input" 
                        id="{{$unavailable->firstName}}" {{ ($unavailable->available == 'unavailable') ? 'checked' : ''}} disabled>
                        <label class="custom-control-label" for="{{$unavailable->firstName}}">{{$unavailable->firstName}} {{$unavailable->lastName}} - 
                        {{-- @foreach ($unavailable->roles as $role)
                            {{$role->display_name}}
                        @endforeach --}}
                        </label>
                    </div>
                    @endforeach
            </div>
            
        </div>
    </div><!--/.col-6 -->
    
</div><!--/.row -->

</div><!--/.container-fluid -->
@endsection
@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                available: []
            }
        });
        
    </script>
@endsection