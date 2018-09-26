@extends('layouts.workcenterlayout')

@section('content')
   <div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
        <h2 class="no-margin-bottom">Edit {!! $department->departmentTitle !!} Departments</h2>
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
    <!-- Departments section -->
    <section class="departments no-padding-bottom">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-6">
                    {!! Form::model($department, ['route' => ['hrmanagement.updateDepartment', $department->id], 'method' => 'POST']) !!}
                    <div class="form-group">
                    <input type="text" name="departmentTitle" value="{{$department->departmentTitle}}" class="form-control" placeholder="Department Title" required>
                    </div>
          
                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="Description" rows="3">{{$department->description}}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="departmentLead" class="text-muted">Current Department Lead: {{$department->departmentLead}}</label>
                    </div>

                    <div class="form-group">
                        <select name="departmentLead" id="" class="form-control" required>
                            <option value="">- Department Leader -</option>
                            @foreach ($users as $user)
                            <option value="{{$user->firstName}} {{$user->lastName}}">{{$user->firstName}} {{$user->lastName}}</option>                       
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Department</button>
                </div>
             {!! Form::close() !!}
            </div>
         
        </div><!--/.row -->
    </section><!--/.Tasklist Section -->
 </div><!--/.container-fluid -->
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".department_delete").on("submit", function(){
        return confirm("Are you sure?");
    });
    
 });
</script>
@endsection