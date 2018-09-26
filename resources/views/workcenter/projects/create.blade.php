@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">New Project</h2>
        </div>
    </header>
    @foreach($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        {{ $message }}
    </div>
@endforeach
    {!! Form::open(array('route' => 'projects.store')) !!}
    <div class="row bg-white has-shadow mt-2 ">
        <div class="col-md-6">
            <div class="card mt-2">
                {{-- <div class="card-header">
                     <strong>Project Details:</strong>   
                </div><!-- /.card-header --> --}}
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="h6 text-muted">Project ID</label>
                                <input type="text" name="pid" class="form-control" id="pid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="h6 text-muted">Project Number</label>
                                <input type="text" name="projectNumber" class="form-control" id="projectNumber" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="h6 text-muted">On Site Contact Name</label>
                                <input type="text" name="clientName" class="form-control" id="clientName" placeholder="" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="h6 text-muted">Project Name</label>
                                <input type="text" name="projectName" class="form-control" id="projectName" placeholder="" >
                            </div>
                        </div>
                   </div>
                   <div class="row justify-content-md-center">
                        <div class="col-md-6">
                             <div class="form-group">
                                    <label class="h6 text-muted">Start Date</label>
                                 <input type="text" name="start_date" id="start_date" class="form-control" placeholder="" required>
                             </div>
                        </div>   
                        <div class="col-md-6">
                             <div class="form-group">
                                    <label class="h6 text-muted">End Date</label>
                                 <input type="text" name="end_date" id="end_date" class="form-control" placeholder="" required>
                             </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label class="h6 text-muted">Client</label>
                                <select name="client_id" id="" class="form-control" >
                                    <option value="">- Select Client -</option>
                                    @foreach ($clients as $client)
                                        <option value="{{$client->id}}">{{$client->firstName}} {{$client->lastName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>   
                    </div>
                    <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                 <div class="form-group">
                                    <label class="h6 text-muted">Description</label>
                                     <textarea class="form-control" name="description" id="description" placeholder="Some details about the project (optional)"></textarea>
                                 </div>
                            </div>
                        </div>
                   <div class="row justify-content-md-center">
                       <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Category</label>
                                <select name="categoryName" id="" class="form-control">
                                <option value=""> - Select Category -</option>
                                @foreach($categories as $category)
                                <option value="{{$category->categoryName}}">{{$category->categoryName}}</option>
                                @endforeach
                            </select>
                            </div>
                       </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Department</label>
                                <select name="departmentTitle" id="departmentTitle" class="form-control" >
                                    <option value=""> - Select Department -</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->departmentTitle}}">{{$department->departmentTitle}}</option>
                                    @endforeach
                                </select>
                            </div>
                       </div>

                   </div>
                   
                   <div class="row justify-content-md-center">
                       <div class="col-md-12">
                            <div class="form-group">
                                    <label class="h6 text-muted">Employee</label>
                                    <select class="form-control select2-multi"  name="users[]" multiple="multiple" style="width: 100%;" required>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}} - 
                                                @foreach ($user->roles as $role)
                                                {{$role->display_name}}
                                              @endforeach
                                            </option>
                                        @endforeach
                                    </select>
                                {{-- <select class="form-control"  name="user"  required>
                                    <option value=""> - Select Employee -</option>
                                    @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}} - 
                                    @foreach ($user->roles as $role)
                                        {{$role->display_name}}
                                      @endforeach</option>
                                    @endforeach
                                </select> --}}
                            </div> 
                       </div>
                   </div>

                   {{-- <div class="row justify-content-md-center">
                       <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">Add Project</button>
                       </div>
                   </div> --}}
                </div><!-- /.card-body -->
            </div><!-- /.card -->
           
        </div><!-- /.col-md-6 -->
        <div class="col-md-6">
            <div class="card mt-2">
                {{-- <div class="card-header">
                        <strong>Project Details:</strong>   
                </div> --}}
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Quote Number</label>
                                <input type="text" name="quoteNumber" class="form-control" id="quoteNumber" placeholder="" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Order Number</label>
                                <input type="text" name="orderNumber" class="form-control" id="orderNumber" placeholder="" >
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">On Site Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">REG/OT?</label>
                                <input type="text" name="productionTime" class="form-control" id="productionTime" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Project Route</label>
                                <input type="text" name="projectDirections" class="form-control" id="projectDirections" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Send Invoice To</label>
                                <input type="text" name="invoiceTo" class="form-control" id="invoiceTo" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="h6 text-muted">Number of Personnel</label>
                                <input type="text" name="numberPersonnel" class="form-control" id="numberPersonnel" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Projected Hours</label>
                                <input type="text" name="projectedHrs" class="form-control" id="projectedHrs" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="h6 text-muted">Quoted Dated Submitted</label>
                                <input type="text" name="quotedDated" class="form-control" id="quotedDated" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Quoted By</label>
                                <input type="text" name="quotedBy" class="form-control" id="quotedBy" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Address Line 1</label>
                                <input type="text" name="address1" class="form-control" id="address1" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Address Line 2</label>
                                <input type="text" name="address2" class="form-control" id="address2" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">City</label>
                                <input type="text" name="city" class="form-control" id="city" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">State</label>
                                <select name="state" id="" class="form-control">
                                    <option value="">- Select State -</option>
                                    @foreach ($states as $state)
                                        <option value="{{$state->state}}">{{$state->state}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Zipcode</label>
                                <input type="text" name="zipcode" class="form-control" id="zipcode" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label class="h6 text-muted">Color</label>
                                <select name="color" id="color" class="form-control" required>
                                    <option value=""> - Select Color -</option>
                                    @foreach ($colors as $color)
                                        <option value="{{$color->value}}" style="{{$color->style}}">{{$color->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                                       
                   <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm pull-right">Add Project</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
    {!! Form::close() !!}
</div><!-- /.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor', 'manager', 'installer'])
@include('workcenter.errors.404')
@endrole

@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $( "#start_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#end_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#quotedDated" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('.select2-multi').select2();
    placeholder: "Select User";

    $('#phone_number').mask('(000) 000-0000');
});
</script>
@endsection