@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])  
<div class="modal fade" id="leaveRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Request Time Off</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'rto.store')) !!}

                <div class="row">
                    <div class="col-12">
                        <select name="user_id" id="" class="form-control">
                                <option value="">- Select Employee -</option>
                            @foreach ($users as $user)                       
                                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_time">Start Time:</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                
    
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end_time">End Time:</label>      
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="reason">Reason:</label>
                            <textarea class="form-control" name="reason" id="reason" placeholder=""></textarea>
                        </div>
                    </div>
                </div>
                    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div><!--/.modal -->
    <div class="container-fluid">
            <!-- Page Header-->
          <header class="page-header">
              <div class="container-fluid">
                  <h2 class="no-margin-bottom">Request Time Off</h2>
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
    <!-- Project Manager section -->
    
    <section class="leaves no-padding-bottom">
        
                <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                    <div class="item d-flex align-items-center">
                        <div class="title">
                            <button type="button" class="btn btn-primary fa fa-plus-circle mt-2 mb-2" data-toggle="modal" data-target="#leaveRequest" data-whatever="@mdo"> Request Time Off</button>
                        </div>
                    </div>
                </div>
                
            </div><!--/.row -->
            
       
    </section><!--/.leave Section -->


<div class="row bg-white has-shadow mt-2 justify-content-md-center">
    <div class="col-12">
        <table class="table table-sm table-responsive">
            <thead>
                <th>Full Name</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Submitted At</th>
                <th></th>
                <th></th>
                {{-- <th></th> --}}
            </thead>
            <tbody>
                @foreach ($leaves as $leave)
                <tr>
                    <td>
                        @foreach ($leave->users as $user)
                            {{$user->firstName}} {{$user->lastName}}
                        @endforeach
                    </td>
                    <td>
                        {{date('F j Y', strtotime($leave->start_date))}}
                    </td>
                    <td>{{date('g:i a', strtotime($leave->start_time))}}</td>
                    <td>
                        {{date('F j Y', strtotime($leave->end_date))}}
                    </td>
                    <td>
                        {{date('F j Y', strtotime($leave->end_time))}}
                    </td>
                    <td>
                        @if ($leave->status == 'pending')
                            <span class="badge badge-secondary">{{$leave->status}}</span>
                        @elseif ($leave->status == 'approved')
                            <span class="badge badge-primary">{{$leave->status}}</span>
                            @elseif ($leave->status == 'denied')
                            <span class="badge badge-danger">{{$leave->status}}</span>
                        @endif
                    </td>
                    <td>
                        {{date('F j Y @ h:i a', strtotime($leave->created_at))}}
                    </td>
                    <td>
                    <a href="{{route('rto.edit', $leave->id)}}" class="btn btn-primary btn-sm fa fa-eye"></a>
                    </td>
                    {{-- <td>
                        <form action="{{ route('rto.update', $leave->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" value="{{$leave->id}}">
                            <button type="submit" class="btn btn-success btn-sm fa fa-check"></button>
                        </form>
                    </td> --}}
                    <td>
                        <form action="{{ route('rto.destroy', $leave->id) }}" method="post" class="leave_delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!--/.col-12 -->
</div><!--/.row -->
</div><!--/.container-fluid -->
@endrole
@role(['supervisor', 'manager', 'employee', 'installer', 'client'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".leave_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection