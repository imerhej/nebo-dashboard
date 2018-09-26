@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container">
                <h2 class="no-margin-bottom">Project Categories</h2>
            </div>
        </header>

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

        <!-- Categories Section -->
        <section class="category">
                <div class="row bg-white has-shadow">
                    <div class="col-sm-2 col-sm-4">
                        <h4 class="h6 mt-2">Add New Project Category</h4>
                        {!! Form::open(array('route' => 'categories.store')) !!}
                            <div class="form-group">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="categoryName" id="categoryName" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mb-2">Add Project Category</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-sm-4 col-sm-8">
                            <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->categoryName }}</td>
                                        <td>{{ str_limit($category->description, 15) }}</td>
                                        <td>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="post" class="category_delete">
                                            <a href="{{route('categories.edit', $category->id)}}" class="btn btn-primary btn-sm fa fa-edit"></a>
                                            
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"></button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </section>
</div>        
@endrole

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".category_delete").on("submit", function(){
        return confirm("Are you sure?");
    });
    
 });
</script>
@endsection