@extends('layouts.workcenterlayout')

@section('content')
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Notifications</h2>
        </div>
    </header>
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
    <section class="notifications-section">
        <div class="row bg-white has-shadow">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-sm table-responsive">
                    <thead>
                        <th>Notification Name</th>
                        <th>Sent To</th>
                        <th>Date Sent</th>
                        <th>Read at</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach(Auth::user()->unreadNotifications as $tasknotification)
                        <tr>
                        <td>{{$tasknotification->data['tasklist']['tasklistname']}}</td>
                            <td></td>
                        <td>{{date('F j Y @ h:i a', strtotime($tasknotification->created_at))}}</td>
                        <td>{{date('F j Y @ h:i a', strtotime($tasknotification->read_at))}}</td>
                        <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>

@endsection