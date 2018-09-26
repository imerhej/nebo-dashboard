@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager', 'manager'])
<div class="container-fluid">
<!-- Page Header-->
<header class="page-header">
        <div class="container-fluid">
            <h5 class="no-margin-bottom">Edit Performance Review </h5>
            <a href="{{route('hrmanagement.performance', $performance->user_id)}}">Performance list</a>
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
    <div class="row bg-white has-shadow mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <form action="{{route('hrmanagement.editperformance', $performance->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="user_id" value="{{$performance->user_id}}" id="">
                    <div class="form-row mt-2">
                        <label for="" class="h4">Employee Information</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{$performance->name}}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="employeeId">Employee ID</label>
                            <input type="text" class="form-control" id="employeeId" placeholder="Employee ID" name="employeeId" value="{{$performance->user_id}}" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jobTitle">Job Title</label>
                            <input type="text" class="form-control" id="jobTitle" placeholder="Job Title" name="jobTitle" value="{{$performance->jobTitle}}" readonly>  
                        </div>
                        <div class="form-group col-md-6">
                            <label for="review_date">Date</label>
                            <input type="text" class="form-control" id="review_date" placeholder="Date" name="review_date" value="{{$performance->review_date}}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="department">Department</label>
                            <input type="text" class="form-control" id="department" placeholder="Department" name="department" value="{{$performance->department}}" readonly>
                         </div>
                        <div class="form-group col-md-6">
                            <label for="manager">Manager</label>
                            <input type="text" class="form-control" id="manager" placeholder="Manager" name="manager" value="{{$performance->manager}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="review_period">Review Period</label>
                            <input type="text" class="form-control" id="review_period" placeholder="Review Period" name="review_period" value="{{$performance->review_period}}" >
                        </div>
                    </div>
                    
                    <div class="form-row mt-2">
                        <label for="" class="h4">Ratings</label>   
                    </div>
                    <div class="form-row">
                            <table class="table table-sm table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">1 &equals; Poor</th>
                                            <th scope="col">2 &equals; Fair</th>
                                            <th scope="col">3 &equals; Satisfactory</th>
                                            <th scope="col">4 &equals; Good</th>
                                            <th scope="col">5 &equals; Excellent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Job Knowledge</th>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="job_knowledge1" name="job_knowledge" value="1" class="custom-control-input" {{$performance->job_knowledge == 1 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="job_knowledge1"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="job_knowledge2" name="job_knowledge" value="2" class="custom-control-input" {{$performance->job_knowledge == 2 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="job_knowledge2"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="job_knowledge3" name="job_knowledge" value="3" class="custom-control-input" {{$performance->job_knowledge == 3 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="job_knowledge3"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="job_knowledge4" name="job_knowledge" value="4" class="custom-control-input" {{$performance->job_knowledge == 4 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="job_knowledge4"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="job_knowledge5" name="job_knowledge" value="5" class="custom-control-input" {{$performance->job_knowledge == 5 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="job_knowledge5"></label>
                                                </div>
                                            </td>                              
                                        </tr>
                                        <tr>
                                        <th scope="row">Work quality</th>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="work_quality1" name="work_quality" value="1" class="custom-control-input" {{$performance->work_quality == 1 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="work_quality1"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="work_quality2" name="work_quality" value="2" class="custom-control-input" {{$performance->work_quality == 2 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="work_quality2"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="work_quality3" name="work_quality" value="3" class="custom-control-input" {{$performance->work_quality == 3 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="work_quality3"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="work_quality4" name="work_quality" value="4" class="custom-control-input" {{$performance->work_quality == 4 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="work_quality4"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="work_quality5" name="work_quality" value="5" class="custom-control-input" {{$performance->work_quality == 5 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="work_quality5"></label>
                                                </div>
                                            </td>                              
                                        </tr>
        
                                        <tr>
                                        <th scope="row">Attendance/Punctuality</th>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadioInline1" name="attendance_punctuality" value="1" class="custom-control-input" {{$performance->attendance_punctuality == 1 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadioInline1"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadioInline2" name="attendance_punctuality" value="2" class="custom-control-input" {{$performance->attendance_punctuality == 2 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadioInline2"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadioInline3" name="attendance_punctuality" value="3" class="custom-control-input" {{$performance->attendance_punctuality == 3 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadioInline3"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadioInline4" name="attendance_punctuality" value="4" class="custom-control-input" {{$performance->attendance_punctuality == 4 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadioInline4"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadioInline5" name="attendance_punctuality" value="5" class="custom-control-input" {{$performance->attendance_punctuality == 5 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customRadioInline5"></label>
                                                </div>
                                            </td>   
                                        </tr>
        
                                        <tr>
                                            <th scope="row">Initiative</th>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="initiative1" name="initiative" value="1" class="custom-control-input" {{$performance->initiative == 1 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="initiative1"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="initiative2" name="initiative" value="2" class="custom-control-input" {{$performance->initiative == 2 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="initiative2"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="initiative3" name="initiative" value="3" class="custom-control-input" {{$performance->initiative == 3 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="initiative3"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="initiative4" name="initiative" value="4" class="custom-control-input" {{$performance->initiative == 4 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="initiative4"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="initiative5" name="initiative" value="5" class="custom-control-input" {{$performance->initiative == 5 ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="initiative5"></label>
                                                </div>
                                            </td>   
                                        </tr>
        
                                        <tr>
                                            <th scope="row">Communication/Listening Skills</th>
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="comm_listening1" name="comm_listening" value="1" class="custom-control-input" {{$performance->comm_listening == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="comm_listening1"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="comm_listening2" name="comm_listening" value="2" class="custom-control-input" {{$performance->comm_listening == 2 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="comm_listening2"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="comm_listening3" name="comm_listening" value="3" class="custom-control-input" {{$performance->comm_listening == 3 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="comm_listening3"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="comm_listening4" name="comm_listening" value="4" class="custom-control-input" {{$performance->comm_listening == 4 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="comm_listening4"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="comm_listening5" name="comm_listening" value="5" class="custom-control-input" {{$performance->comm_listening == 5 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="comm_listening5"></label>
                                                    </div>
                                                </td>   
                                            </tr>
        
                                            <tr>
                                                <th scope="row">Dependability</th>
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="dependability1" name="dependability" value="1" class="custom-control-input" {{$performance->dependability == 1 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="dependability1"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="dependability2" name="dependability" value="2" class="custom-control-input" {{$performance->dependability == 2 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="dependability2"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="dependability3" name="dependability" value="3" class="custom-control-input" {{$performance->dependability == 3 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="dependability3"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="dependability4" name="dependability" value="4" class="custom-control-input" {{$performance->dependability == 4 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="dependability4"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="dependability5" name="dependability" value="5" class="custom-control-input" {{$performance->dependability == 5 ? 'checked' : ''}}>
                                                            <label class="custom-control-label" for="dependability5"></label>
                                                        </div>
                                                    </td>   
                                            </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-row">
                                <label for="rating_comments"><i>Rating Comments</i></label>
                                <textarea name="rating_comments" class="form-control" id="comments" cols="30" rows="3">{!! $performance->rating_comments !!}</textarea>
                            </div>
                            <div class="form-row mt-2">
                                    <label for="" class="h4">Evaluation</label>
                            </div>
                            <div class="form-row">
                                <label for="additional_comments">Additional Comments</label>
                                <textarea name="additional_comments" id="additional_comments" class="form-control" cols="30" rows="3">{!! $performance->additional_comments !!}</textarea>   
                            </div>
                            <div class="form-row">
                                <label for="goals">GOALS <i class="text-muted">(as agreed upon by employee and manager)</i></label>
                                <textarea name="goals" id="goals" class="form-control" cols="30" rows="3">{!! $performance->goals !!}</textarea>   
                            </div>

                            <div class="form-row mt-2">
                                    <label for="" class="h4">Verification of Review</label>
                                <i class="text-muted">By signing this form, you confirm that you have discussed this review in detail with your supervisor. Signing this form does not necessarily indicate that you agree with this evaluation.</i>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                     <label for="employee_signature">Employee Signature</label>
                                    <input type="text" name="employee_signature" class="form-control" id="" placeholder="Employee Signature" value="{!! $performance->employee_signature !!}" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee_date">Date</label>
                                    <input type="text" name="employee_date" class="form-control" id="employee_date" placeholder="Employee Signature Date" value="{!! $performance->employee_date !!}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                        <label for="manager_signature">Manger Signature</label>
                                    <input type="text" name="manager_signature" class="form-control" id="" placeholder="Manager Signature" value="{!! $performance->manager_signature !!}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="manager_date">Date</label>
                                    <input type="text" name="manager_date" class="form-control" id="manager_date" placeholder="Manager Signature Date" value="{!! $performance->manager_date !!}">
                                </div>
                            </div>
                            <div class="form-row mt-2 mb-2">
                                   <div class="form-group col-md-12">
                                        <input type="submit" class="btn btn-primary btn-sm pull-right" value="Update" id="">
                                   </div>
                            </div>
                        
                    </form>
               
            </div>
    </div>
</div><!-- /.container-fluid -->
@endrole
@role(['employee', 'client', 'supervisor', 'installer'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $( "#review_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#employee_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#manager_date" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    
});
</script>
@endsection