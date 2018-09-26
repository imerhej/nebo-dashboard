@extends('layouts.workcenterlayout')

@section('content')

<div class="container-fluid">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="h4 no-margin-bottom">Discussion </h2> 
            <span class="text-muted"></span>
        </div>
    </header>
     <!-- Discussions section -->
        <section class="discussions-list">
            <div class="row bg-white has-shadow justify-content-md-center">
               
                <div class="col-md-8 mt-2">
                        {!! Form::model($post, ['route' => ['projects.editDiscussion', $post->id], 'method' => 'PUT']) !!}
                        <input type="hidden" name="project_id" value="{{$project_id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="form-group">
                            {!! Form::textarea('message', null, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Write Something...', 'required' => '']) !!}
                            {{-- <textarea name="message" id="article-ckeditor" class="form-control" required="required" >{!! $post->message !!}</textarea> --}}
                        </div>
                        <button type="submit" class="btn btn-primary pull-right mb-3">Update Discussion</button>        
                    {!! Form::close() !!}                      
                </div>                
            </div><!--/.row -->
        </section><!--/.discussion-list -->
</div><!--/.container-fluid -->
@endsection
@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.env.isCompatible = true;
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
@endsection