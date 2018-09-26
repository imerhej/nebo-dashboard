@extends('layouts.workcenterlayout')

@section('content')
<div class="modal fade" id="newDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Department</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form  action="{{route('hrmanagement.departments')}}" method="POST">
                        {{ csrf_field() }}
                
                <div class="form-group">
                    <input type="text" name="departmentTitle" class="form-control" placeholder="Department Title" required>
                </div>
      
                <div class="form-group">
                    <textarea name="description" class="form-control" placeholder="Description" rows="3"></textarea>
                </div>
    
                <div class="form-group">
                    <select name="departmentLead" id="" class="form-control">
                        <option value="">- Department Leader -</option>
                        @foreach ($users as $user)
                        <option value="{{$user->firstName}} {{$user->lastName}}">{{$user->firstName}} {{$user->lastName}}</option>                       
                        @endforeach
                    </select>
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create Department</button>
            </div>
            </form>
          </div>
        </div>
    </div><!--/.modal -->
    
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container">
            <h2 class="no-margin-bottom">Departments</h2>
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
    <section class="departments no-padding-bottom">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="title">
                        <button type="button" class="btn btn-primary fa fa-plus-circle mb-2" data-toggle="modal" data-target="#newDepartment" data-whatever="@mdo"> New Department</button>
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
    
    <section class="departments">
        <div class="row bg-white has-shadow">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Department Lead</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                        <tr>
                            <td>{!! $department->departmentTitle!!}</td>
                            <td>{!! $department->departmentLead!!}</td>
                            <td>{!! $department->description!!}</td>

                            <td>
                                <form action="{{ route('hrmanagement.destroyDepartment', $department->id) }}" method="post" class="department_delete">
                                    <a href="{{ route('hrmanagement.editDepartment', $department->id) }}" class="btn btn-primary btn-sm fa fa-edit"></a>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!--/.row -->
    </section>

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