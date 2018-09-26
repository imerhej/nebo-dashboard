@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">{{$user->firstName}}'s profile image</h2>
        </div>
    </header>
    <div class="row bg-white has-shadow mt-2">
        <div class="col-4 mt-3 mb-3">
            <img src="/uploads/avatars/{{ $user->avatar }}" alt="" style="width: 150px; height: 150px; float:left; border-radius: 50%; margin-right; 25px;">
        </div>
        <div class="col-4 mt-3">
                {!! Form::open(['route' => ['myaccount.avatar', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {{-- <form action="{{route('myaccount.avatar', $user->id)}}" method="POST" enctype="multipart/form-data"> --}}
                <label for="">Update profile image</label><br>
                <input type="file" name="avatar" id="" class="mb-2" required>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-primary btn-sm" value="Submit">
            {{-- </form> --}}
            {!! Form::close() !!}
        </div>
    </div>
</div><!--/.container-fluid-->
@endsection