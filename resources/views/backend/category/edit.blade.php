@extends('backend.layouts.app')
@push('styles')
@endpush

@section('content')
<div class="right_col" role="main">
        <h1>Edit Category Info<a href="{{route('admin.category.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Product Categories</a></h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.category.update', $category->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Category Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$category->name}}" placeholder="Category Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

@push('scripts')

@endpush

