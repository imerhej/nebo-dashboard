@extends('layouts.workcenterlayout')

@section('content')
<div class="modal fade" id="discussion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Start New Discussion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => ['projects.discussions', $project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div class="form-group">
                    {{-- {{ Form::textarea('message', null, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Write Something...', 'required' => '']) }} --}}
                    <textarea name="message" id="article-ckeditor" class="form-control" required ></textarea>
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Post Discussion</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div><!--/.modal -->
<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="h4 no-margin-bottom"><a href="{{route('projects.show', $project->id)}}">{{$project->projectName}}</a> </h2> 
            <span class="text-muted">Discussion</span>
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

    <div class="row">
            <div class="container">
                @if (session('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('danger') }}
                    </div>
                @endif
            </div>
        </div>
     <!-- Discussions section -->
     <section class="tasklists no-padding-bottom">
            <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                    <div class="item d-flex align-items-center">
                        <div class="title">
                            <button type="button" class="btn btn-primary fa fa-plus-circle mb-2" data-toggle="modal" data-target="#discussion" data-whatever="@mdo"> New Discussion</button>
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
        </section><!--/.Section -->

        <section class="discussions-list">
            <div class="row bg-white has-shadow">
                @foreach ($posts as $post)
                <div class="col-12 mt-2">
                    <blockquote class="blockquote">
                        <span class="mb-0">{!! $post->message !!}</span>
                          <footer class="blockquote-footer">
                            Posted by: 
                            @foreach ($post->users as $user) 
                            {{$user->firstName}} {{$user->lastName}}
                            @endforeach
                            | Created at: {{ date('F j Y @ h:i a', strtotime($post->created_at)) }} 
                            | Updated at: {{ date('F j Y @ h:i a', strtotime($post->updated_at)) }} 
                            @if (Auth::user()->id == $user->id) 
                            | <span><a href="{{route('projects.editDiscussion', $post->id)}}"> Edit</a></span>
                            @endif
                            @if (Auth::user()->id == $user->id) 
                            | <form action="{{ route('projects.discussions', $post->id) }}" method="post" class="post_delete">
                            
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o mb-2 pull-right"></button>
                            
                                 </form>
                            @endif

                        </footer>
                    </blockquote>
                </div>
                @endforeach
            </div><!--/.row -->
        </section><!--/.discussion-list -->
</div><!--/.container-fluid -->
@endsection
@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.env.isCompatible = true;
        CKEDITOR.replace( 'article-ckeditor' );
        $(document).ready(function(){
      $(".post_delete").on("submit", function(){
         return confirm("Are you sure?");
      });
   });
    </script>
@endsection