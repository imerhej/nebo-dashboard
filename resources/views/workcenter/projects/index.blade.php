@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Project Manager</h2>
        </div>
    </header>
    <!-- Success Message -->
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

        
    <!-- Project Manager section -->
    @role(['superadministrator', 'administrator', 'office-manager'])
    <section class="project-manager no-padding-bottom">
        
                <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                    <div class="item d-flex align-items-center">
                        <div class="title">
                            <a href="{{route('projects.create')}}" class="btn btn-primary btn-sm fa fa-plus-circle mb-2"> New Project</a>
                        </div>
                    </div>
                </div>
                <!-- Item -->
                <div class="col-xl-4 col-sm-6">
                    <div class="item d-flex align-items-center">
                        <div class="title">
                                {{-- <a href="{{route('projects.rates')}}" class="btn btn-primary btn-sm" id="addRates"> Add Rates</a>                         --}}
                                {{--<div class="form-group mx-sm-3 mb-2">
                                    <select class="form-control form-control-sm mr-2" id="categoryName">
                                        <option value="">- Project Category -</option>
                                        @foreach($categories as $category)
                                        <option name="filter" value="{{$category->categoryName}}">{{$category->categoryName}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary btn-sm mb-2" id="filter">Filter</button>   
                                </div>
                            </form> --}}
                            
                        </div>
                    </div>
                </div>
                <!-- Item -->
                {{-- <div class="col-xl-5 col-sm-6">
                    <div class="item d-flex align-items-center">
                        <form action="{{route('projects.index')}}" method="POST" role="search">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                    placeholder="Search Projects"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div> --}}
            </div><!--/.row -->
            
       
    </section><!--/.Project Manager Section -->
    @endrole

    {{-- @if (Auth::user()->id == $user->id || $userPermission) --}}
        <div class="row links bg-white has-shadow">
            <div class="col-sm">
                <div class="title text-center"> 
                <a href="{{route('projects.index')}}" class="padding-top mb-2">
                        <i class="icon-grid"></i> 
                        All 
                    </a>
                </div>
            </div>
            <div class="col-sm">
                <div class="title text-center">
                    {{-- <a href="/workcenter/projects?active=1" class="padding-top mb-2"> --}}
                        <a href="#" class="padding-top mb-2">
                        <i class="icon-clock"></i> 
                    Active @foreach ($activeCounts as $activeCount) {{$activeCount->activeProjects}} @endforeach
                     </a>
                </div>
            </div>
            <div class="col-sm">
                <div class="title text-center">
                        {{-- <a href="/workcenter/projects?active=0" class="padding-top mb-2"> --}}
                    <a href="#" class="padding-top mb-2">
                        <i class="icon-close"></i> 
                        Completed @foreach ($completedCounts as $completedcount) {{$completedcount->completedProjects}} @endforeach
                    </a>
                </div>
            </div>
        </div>
    {{-- @endif --}}
    @role(['superadministrator', 'administrator', 'office-manager', 'manager'])
    <section class="projects">
            <div class="row projects bg-white has-shadow">
                @foreach ($projects as $project)
                {{-- @foreach ($project->users as $user) --}}
                {{-- @if (Auth::user()->id === $user->id || $userPermission) --}}
                {{-- @if ($userPermission) --}}
                    <div class="col-sm-4">
                        <div class="card mt-3">
                            <a href="{{route('projects.show', $project->id)}}" class="project-link">
                                <div class="card-header project-name">
                                    {!! $project->projectName !!}
                                    <i class="fa fa-cog float-right"></i>
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="row project-details">
                                    <div class="col-6">
                                        <ul>
                                        <li><img src="{{asset('img/discussion.png')}}"> 
                                        <a href="{{route('projects.discussions', ['project_id' => $project->id])}}">{{$project->discussions->count()}} Discussions</a>
                                        </li>
                                        {{-- <li><img src="{{asset('img/tasks.png')}}"> 
                                            <a href=""> Tasks</a>
                                        </li> --}}
                                        <li><img src="{{asset('img/files.png')}}"> 
                                        <a href="{{route('projects.files', ['project_id' => $project->id])}}">{{$project->files->count()}} Files</a>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul>
                                            <li><img src="{{asset('img/tasks.png')}}"> 
                                                <a href="{{route('projects.tasklists', ['project_id' => $project->id])}}">
                                                        {{$project->tasklist->count()}} Task List
                                                </a>
                                            </li>
                                            {{-- <li><img src="{{asset('img/comments.png')}}"> 
                                                <a href=""> Comments</a>
                                            </li> --}}
                                            <li><img src="{{asset('img/discussion.png')}}"> 
                                                <a href="{{route('projects.milestones', ['project_id' => $project->id])}}"> {{$project->milestone->count()}} Milestones</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted text-center">
                            <label class="date-label ">Created At: {{ date('F j Y @ h:i a', strtotime($project->created_at)) }}</label>
                            <label for="status-label">Status: 
                                @if ($project->active == '1')
                                <span class="active-project">Active</span>
                                @elseif ($project->active == '0')
                                <span class="completed-project">Completed</span>
                                @endif
                                {{-- @foreach($activeCounts as $activeTask)
                                @if ($activeTask->activeProjects <= $project->tasklist->count() )
                                <label for="status-label">Status: 
                                <span class="active-project">Active</span>
                                @endif
                                @endforeach
                                @foreach ($completedCounts as $completedTask)
                                @if ($completedTask->completedProjects == $project->tasklist->count())
                                <label for="status-label">Status: 
                                <span class="completed-project">Completed</span>
                                @endif
                                @endforeach --}}
                            </label>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                    {{-- @endif --}}
                {{-- @endforeach --}}
                @endforeach
            </div>
    </section>
@endrole
@role(['supervisor'])
    <section class="projects">
            <div class="row projects bg-white has-shadow">
                @foreach ($projects as $project)
                {{-- @foreach ($project->users as $user) --}}
                {{-- @if (Auth::user()->id === $user->id || $userPermission) --}}
                {{-- @if ($userPermission) --}}
                    <div class="col-sm-4">
                        <div class="card mt-3">
                            <a href="{{route('projects.show', $project->id)}}" class="project-link">
                                <div class="card-header project-name">
                                    {!! $project->projectName !!}
                                    <i class="fa fa-cog float-right"></i>
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="row project-details">
                                    <div class="col-6">
                                        <ul>
                                        <li><img src="{{asset('img/discussion.png')}}"> 
                                        <a href="{{route('projects.discussions', ['project_id' => $project->id])}}">{{$project->discussions->count()}} Discussions</a>
                                        </li>
                                        {{-- <li><img src="{{asset('img/tasks.png')}}"> 
                                            <a href=""> Tasks</a>
                                        </li> --}}
                                        <li><img src="{{asset('img/files.png')}}"> 
                                        <a href="{{route('projects.files', ['project_id' => $project->id])}}">{{$project->files->count()}} Files</a>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul>
                                            <li><img src="{{asset('img/tasks.png')}}"> 
                                                <a href="{{route('projects.tasklists', ['project_id' => $project->id])}}">
                                                        {{$project->tasklist->count()}} Task List
                                                </a>
                                            </li>
                                            {{-- <li><img src="{{asset('img/comments.png')}}"> 
                                                <a href=""> Comments</a>
                                            </li> --}}
                                            <li><img src="{{asset('img/discussion.png')}}"> 
                                                <a href="{{route('projects.milestones', ['project_id' => $project->id])}}"> {{$project->milestone->count()}} Milestones</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted text-center">
                            <label class="date-label ">Created At: {{ date('F j Y @ h:i a', strtotime($project->created_at)) }}</label>
                            <label for="status-label">Status: 
                                @if ($project->active == '1')
                                <span class="active-project">Active</span>
                                @elseif ($project->active == '0')
                                <span class="completed-project">Completed</span>
                                @endif
                                {{-- @foreach($activeCounts as $activeTask)
                                @if ($activeTask->activeProjects <= $project->tasklist->count() )
                                <label for="status-label">Status: 
                                <span class="active-project">Active</span>
                                @endif
                                @endforeach
                                @foreach ($completedCounts as $completedTask)
                                @if ($completedTask->completedProjects == $project->tasklist->count())
                                <label for="status-label">Status: 
                                <span class="completed-project">Completed</span>
                                @endif
                                @endforeach --}}
                            </label>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                    {{-- @endif --}}
                {{-- @endforeach --}}
                @endforeach
            </div>
    </section>
@endrole
</div><!-- /.container-fluid -->
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('.select-multi').select2();
});
</script>
@endsection