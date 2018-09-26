@extends('layouts.workcenterlayout')

@section('content')
@role(['superadministrator', 'administrator', 'office-manager'])
<div class="container-fluid">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="no-margin-bottom">Project Categories</h2>
            </div>
        </header>
        <!-- Categories Section -->
        <section class="category no-padding-bottom">
            <div class="container-fluid">
                <div class="row bg-white has-shadow">
                    <div class="col-sm-2 col-sm-4">
                    <h4 class="h6 mt-2">Edit {{$category->categoryName}} category </h4>
                        {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PUT']) !!}
                            <div class="form-group">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="categoryName" id="categoryName" value="{{$category->categoryName}}" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control">{{$category->description}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mb-2">Update Project Category</button>
                        {!! Form::close() !!}
                    </div>
                    <!-- Show Category Details -->
                    <div class="col-sm-4 col-sm-8">
                            <h4 class="h6 mt-2"> {{$category->categoryName}} Category - Details</h4>
                            <table class="table table-responsive">
                                <tr>
                                    <td><label for="categoryName" class="form-label">Name:</label></td>
                                    <td>{{$category->categoryName}}</td>
                                </tr>
                                <tr>
                                    <td><label for="description" class="form-label">Description:</label></td>
                                    <td>{{$category->description}}</td>
                                </tr>
                                <tr>
                                    <td><label for="created_at" class="form-label">Created At:</label></td>
                                    <td>{{ date('F j Y @ h:i a', strtotime($category->created_at))}}</td>
                                </tr>
                                <tr>
                                    <td><label for="updated_at" class="form-label">Updated At:</label></td>
                                    <td>{{ date('F j Y @ h:i a', strtotime($category->updated_at))}}</td>
                                </tr>
                            </table>
                    </div>
                </div>
            </div>
        </section>
</div>
@endrole
@endsection