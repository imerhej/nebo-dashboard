@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
            <h2 class="no-margin-bottom">HR Management</h2>
        </div>
    </header>

    <section class="hrmanagement">
        <div class="row bg-white has-shadow">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-body">
                    <span class="hr-count">{{$users->count()}}</span>
                        <h5 class="card-title text-muted">Employees</h5>                        
                    </div>
                    <div class="text-center card-footer bg-blue">
                    <a href="{{route('users.index')}}" class="hr-links">View Employees</a> 
                    </div>                   
                </div><!--/.card -->
            </div>

            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-body">
                    <span class="hr-count">{{$departments->count()}}</span>
                        <h5 class="card-title text-muted">Deparments</h5>                        
                    </div>
                    <div class="text-center card-footer bg-blue">
                    <a href="{{route('hrmanagement.departments')}}" class="hr-links">View Deparments</a> 
                    </div>                   
                </div><!--/.card -->
            </div>

                <div class="col-md-4">
                    <div class="card mt-2">
                        <div class="card-body">
                            <span class="hr-count">{{$projects->count()}}</span>
                            <h5 class="card-title text-muted">Projects</h5>                        
                        </div>
                        <div class="text-center card-footer bg-blue">
                            <a href="{{route('projects.index')}}" class="hr-links">View Projects</a> 
                        </div>                   
                    </div><!--/.card -->
                </div>
        </div><!--/.row -->
    </section>

</div><!--/.container-fluid -->
@endsection