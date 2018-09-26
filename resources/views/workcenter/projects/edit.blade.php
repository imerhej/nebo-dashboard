@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Edit {!!$project->projectName !!}</h2>
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

    {!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT']) !!} 
    {{-- <input type="hidden" name="selectedId" value="{{$selectedId}}"> --}}
    <div class="row bg-white has-shadow mt-2">
        <div class="col-md-6 ">
                <div class="card mt-2">
                    {{-- <div class="card-header">
                         <strong>Project Details:</strong>   
                    </div><!-- /.card-header --> --}}
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="h6 text-muted">Project ID</label>
                                <input type="text" name="pid" value="{{$project->pid}}" class="form-control" id="pid" placeholder="" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="h6 text-muted">Project Number</label>
                                    <input type="text" name="projectNumber" value="{{$project->projectNumber}}" class="form-control" id="projectNumber" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h6 text-muted">On Site Contact Name</label>
                                        <input type="text" name="clientName" value="{{$projectDetails->clientName}}" class="form-control" id="clientName" placeholder="" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h6 text-muted">Project Name</label>
                                        {!! Form::text('projectName', $project->projectName, ['class' => 'form-control', 'placeholder' => '']) !!}
                                    </div>
                                </div>
                           </div>
                           <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                     <div class="form-group">
                                            <label class="h6 text-muted">Start Date</label>
                                         <input type="text" name="start_date" id="start_date" value="{{$project->start_date}}" class="form-control" placeholder="" required>
                                     </div>
                                </div>   
                                <div class="col-md-6">
                                     <div class="form-group">
                                            <label class="h6 text-muted">End Date</label>
                                         <input type="text" name="end_date" id="end_date" value="{{$project->end_date}}" class="form-control" placeholder="" required>
                                     </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                    <label class="h6 text-muted">Client</label>
                                                <select name="client_id" id="" class="form-control" required>
                                                    <option value="">- Select Client -</option>
                                                    {{-- @foreach ($projectclient as $pclient) --}}
                                                    @foreach ($clients as $client)
                                                    @if ($projectclient == null)
                                                        <option value="{{$client->id}}" >{{$client->firstName}} {{$client->lastName}}</option>  
                                                    @elseif ($projectclient != null)  
                                                        <option value="{{$client->id}}" {{ $projectclient->id  == $client->id ? 'selected' : '' }}>{{$client->firstName}} {{$client->lastName}}</option> 
                                                    @endif                                           
                                                    @endforeach
                                                    {{-- @endforeach --}}
                                                </select>
                                            </div>
                                    </div>   
                                </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                        <div class="form-group">
                                        <label class="h6 text-muted">Description</label>
                                        <textarea class="form-control" name="description" id="description" placeholder="Some details about the project (optional)">{{$project->description}}</textarea>
                                        </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                        <div class="form-group">
                                                <label class="h6 text-muted">Category</label>
                                            <select name="categoryName" id="" class="form-control">
                                            <option value=""> - Project Category -</option>
                                            @foreach($categories as $category)
                                            {{-- @foreach ($project->category as $projectCategory) --}}
                                                <option value="{{$category->categoryName}}" {{ $project->categoryName == $category->categoryName ? 'selected' : '' }}>{{$category->categoryName}}</option>
                                            {{-- @endforeach --}}
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
                                                {{-- @foreach($project->department as $projectDepartment) --}}
                                                    <option value="{{$department->departmentTitle}}" {{ $project->departmentTitle == $department->departmentTitle ? 'selected' : '' }}>{{$department->departmentTitle}}</option>
                                                {{-- @endforeach --}}
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                        <div class="form-group">
                                            {{-- <select class="form-control select2-multi"  name="users[]" multiple="multiple" style="width: 100%;">
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}} - 
                                                @foreach ($user->roles as $role)
                                                    {{$role->display_name}}
                                                    @endforeach
                                                </option>
                                                @endforeach
                                            </select> --}}
                                            <label class="h6 text-muted">Employee</label>
                                            <div class="form-group">
                                                {{ Form::select('users[]', $users, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple'])}}
                                            </div>
                                            {{-- <select class="form-control"  name="user" required>
                                                    <option value="">- Select Employee -</option>
                                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{($user->id == $userProject->id) ? 'selected' : ''}}>{{$user->firstName}} {{$user->lastName}} - 
                                                        @foreach ($user->roles as $role)
                                                            {{$role->display_name}}
                                                          @endforeach</option>
                                                        @endforeach
                                                    </select> --}}

                                        {{-- <label for="select-users" class="text-muted">- Select Employees -</label> --}}
                                        {{-- {{ Form::select('users[]', $users, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple', 'required' => 'required'])}} --}}
                                        </div> 
                                </div>
                            </div>

                       <div class="row justify-content-md-center">
                           <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="active" name="active" value="1" {{ ($project->active == 1) ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="active">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="completed" name="active" value="0" {{ ($project->active == 0) ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="completed">Complete</label>
                                    </div>
                                </div>
                           </div>
                           
                       </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!--/.col-md-6 -->
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
                                        <input type="text" name="quoteNumber" value="{{$project->quoteNumber}}" class="form-control"  id="quoteNumber" placeholder="" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Order Number</label>
                                        <input type="text" name="orderNumber" value="{{$project->orderNumber}}" class="form-control" id="orderNumber" placeholder="" >
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">On Site Phone Number</label>
                                        <input type="text" name="phone_number" value="{{$projectDetails->phone_number}}" class="form-control" id="phone_number" placeholder="" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">REG/OT?</label>
                                        <input type="text" name="productionTime" value="{{$projectDetails->productionTime}}"  class="form-control" id="productionTime" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Project Route</label>
                                        <input type="text" name="projectDirections" value="{{$projectDetails->projectDirections}}" class="form-control" id="projectDirections" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Send Invoice To</label>
                                        <input type="text" name="invoiceTo" value="{{$projectDetails->invoiceTo}}" class="form-control" id="invoiceTo" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Number of Personnel</label>
                                        <input type="text" name="numberPersonnel" value="{{$projectDetails->numberPersonnel}}" class="form-control" id="numberPersonnel" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Projected Hours</label>
                                        <input type="text" name="projectedHrs" value="{{$projectDetails->projectedHrs}}" class="form-control" id="projectedHrs" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h6 text-muted">Quoted Dated Submitted</label>
                                        <input type="text" name="quotedDated" value="{{$projectDetails->quotedDated}}" class="form-control" id="quotedDated" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="h6 text-muted">Quoted By</label>
                                        <input type="text" name="quotedBy" value="{{$projectDetails->quotedBy}}" class="form-control" id="quotedBy" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Address Line 1</label>
                                        <input type="text" name="address1" value="{{$projectDetails->address1}}" class="form-control" id="address1" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Address Line 2</label>
                                        <input type="text" name="address2" value="{{$projectDetails->address2}}" class="form-control" id="address2" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">City</label>
                                        <input type="text" name="city" value="{{$projectDetails->city}}" class="form-control" id="city" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">State</label>
                                         <select name="state" id="" class="form-control" >
                                            <option value="">- Select State -</option>
                                            @foreach ($states as $state)
                                                <option value="{{$state->state}}" {{$projectDetails->state == $state->state ? 'selected' : ''}} >{{$state->state}}</option>
                                            @endforeach
                                         </select>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Zipcode</label>
                                        <input type="text" name="zipcode" value="{{$projectDetails->zipcode}}" class="form-control" id="zipcode" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="h6 text-muted">Color</label>
                                        <select name="color" id="color" class="form-control" required>
                                            <option value=""> - Select Color -</option>
                                            @foreach ($colors as $color)
                                            <option value="{{$color->value}}" style="{{$color->style}}" {{$project->color == $color->value ? 'selected' : ''}}>{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right">Update Project</button>
                               </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.col-md-6 -->
        </div><!--/.row -->
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
    $('#phone_number').mask('(000) 000-0000');
});
</script>
@endsection