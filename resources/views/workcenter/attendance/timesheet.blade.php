@extends('layouts.workcenterlayout')

@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Clock In</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    {!! Form::open(array('route' => 'attendance.timesheet')) !!}
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row mt-1">
                        <div class="col-4">
                            <div class="form-group">
                            <input type="text"  name="date_in" id="date_in" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="time" name="time_in" id="time_in" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm mt-1">Clock In</button>
                            </div>  
                        </div>
                    </div>
                </div>
              {!! Form::close() !!}
            
          </div>
        </div>
      </div>
      <div class="modal fade" id="clockout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Clock Out</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                {!! Form::open(array('route' => 'attendance.timesheet')) !!}
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="row mt-1">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="time" name="time_in" id="time_in" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm mt-1">Clock Out</button>
                                </div>  
                            </div>
                        </div>
                    </div>
                  {!! Form::close() !!}
                
              </div>
            </div>
          </div>
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Attendance Timesheet</h2>
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

    <div class="row bg-white has-shadow">
        <div class="col-6 mt-2">
                
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Clock In</button>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#clockout" data-whatever="@mdo">Clock Out</button>
            

                

                {{-- <div class="row mt-1">
                    <div class="col-4">
                        <div class="form-group">
                            <input type="time" name="break_out" id="break_out" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm mt-1">Break Out</button>
                        </div>  
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-4">
                        <div class="form-group">
                            <input type="time" name="break_in" id="break_in" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm mt-1">Break In</button>
                        </div>  
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" name="travel_time" id="travel_time" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm mt-1">Submit</button>
                        </div>  
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" name="installation_time" id="installation_time" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm mt-1">Submit</button>
                        </div>  
                    </div>
                </div> --}}
                        
            
        </div>
    </div>
</div><!--/.container-fluid -->
@endsection
@section('scripts')
{{-- <script src="{{ asset('js/moment.min.js') }}"></script> --}}

<script>
    // $(document).ready(function(){
    //     $('#punchIn').click(function(){
    //         alert('You just clocked in , Thank you!');
    //     });
    //     $('#punchOut').click(function(){
    //         alert('You just clocked out , Thank you!');
    //     });
    // });
    $( "#date_in" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    $( "#date_out" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    function myFunction() {
    // var punch_in = document.getElementById("punch_in").value;
    // var punch_out = document.getElementById("punch_out").value;
    
    // var punch_in_time = new Date(punch_in);
    // var punch_out_time = new Date(punch_out);

    

    // var diff = (punch_out_time.getTime() - punch_in_time.getTime())/1000;
    // diff /= 60*60;
    // newDiff = Math.abs(Math.round(diff));
    // document.getElementById('total').innerHTML = newDiff + " Hour";

    // document.getElementById("punch_in_time").innerHTML = punch_in;
    // document.getElementById("punch_out_time").innerHTML = punch_out;
}
</script>
@endsection