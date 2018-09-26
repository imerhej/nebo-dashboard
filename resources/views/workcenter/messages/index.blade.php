@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'manager', 'supervisor', 'installer', 'employee'])
<div class="container-fluid">
        <!-- Page Header-->
      <header class="page-header">
          <div class="container-fluid">
              <h2 class="no-margin-bottom">Messages</h2>
          </div>
      </header>
      <div class="row bg-white has-shadow mt-2">
            <div class="col-xl-3 col-sm-6">
                    <div class="item d-flex align-items-center">
                        <div class="title">
                            {{-- <button type="button" class="btn btn-primary fa fa-plus-circle mb-2" data-toggle="modal" data-target="#newProject" data-whatever="@mdo"> New Project</button> --}}
                            <a href="{{route('messages.create')}}" class="btn btn-primary fa fa-plus-circle mb-2 mt-2"> New Message</a>
                        </div>
                    </div>
                </div>
      </div>
    <div class="row bg-white has-shadow justify-content-md-center mt-2">
        <div class="col-xs-8 col-sm-8 col-md-8">
            @if (count(Auth::user()->messages) != 0)
            <table class="table table-sm table-responsive table-hover mt-2">
                <thead>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Recieved at</th>
                    <th>
                            
                    </th>
                    <th></th>
                </thead>
                <tbody>
                    
                    @foreach ($messages as $message)
                    @if (Auth::user()->id == $message->recipient_id)
                    <tr>
                        <td>
                        <a href="{{route('messages.show', $message->id)}}">
                            {{$message->sender}}
                        </a>
                        </td>
                        <td>{{$message->subject}}</td>
                        <td>{{date('F j Y @ h:i a', strtotime($message->created_at))}}</td>
                        <td>
                            <form action="{{ route('messages.update', $message->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}  
                                <button type="submit" class="btn btn-primary btn-sm fa fa-eye"></button>
                            </form>
                            {{-- {!! Form::model($message,['route' => ['messages.update', $message->id], 'method' => 'PUT']) !!}

                            {!! Form::submit('Read More', ['class' => 'btn btn-primary btn-sm']) !!}

                            {!! Form::close() !!} --}}
                        </td>
                        <td>
                            <form action="{{ route('messages.destroy', $message->id) }}" method="post" class="message_delete">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"></button>
                                </form>
                                
                            </a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            @endif
            @if (count(Auth::user()->messages) == 0)
                <div class="mt-3">
                    <p>No new Messages</p>
                </div>
            @endif
            {{$messages->links()}}
        </div>
        
    </div> <!--/.row -->
    
</div><!--/.container-fluid-->
@endrole
@role(['client'])
@include('workcenter.errors.404')
@endrole
@endsection
@section('scripts')
  <script>
    $(document).ready(function(){
      $(".message_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
  </script>
@endsection