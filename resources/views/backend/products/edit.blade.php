@extends('backend.layouts.app')
@push('styles')
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<style>
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #26B99A;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #26B99A;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
</style>
@endpush
@section('content')
<div class="right_col" role="main">
    @if(session()->has('success'))
                <div class="alert alert-success" style="position: none; margin-top: 4rem;">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{-- @if($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{$error}}
                    @endforeach
                </div>
            @endif --}}
            @if(session()->has('failure'))
                <div class="alert alert-danger" style="position: none; margin-top: 4rem;">
                    {{ session()->get('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        <h1>Edit Product Details <a href="{{route('admin.product.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Products</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.product.update', $product->id)}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_name">Product Name: </label>
                                            <input type="text" name="product_name" class="form-control" value="{{@old('product_name')?@old('product_name'):$product->name}}" placeholder="Product Name">
                                            @error('product_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_price">Unit Price (Rs.): </label>
                                            <input type="text" name="unit_price" class="form-control" value="{{@old('unit_price')?@old('unit_price'):$product->unit_price}}" placeholder="Unit Price in Rs.">
                                            @error('unit_price')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity / Stock: </label>
                                            <input type="text" name="quantity" class="form-control" value="{{@old('quantity')?@old('quantity'):$product->stock}}" placeholder="Quantity/ Stock">
                                            @error('quantity')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="variant">Product Variant: </label>
                                            <input type="text" name="variant" class="form-control" value="{{@old('variant')?@old('variant'):$product->info}}" placeholder="Eg: 500 ml, 20 kgs">
                                            @error('variant')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categories">Product Category: </label>
                                            <select class="form-control chosen-select" data-placeholder="Type category names..." multiple name="categories[]">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ in_array($category->id, $product->categories) ? "selected":"" }}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('categories')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="images">Product image:</label>
                                            <input type="file" class="form-control" name="images">
                                            @error('images')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <p class="text-danger">Don't select another picture if you want previous picture.</p>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <hr>
                    <div class="card">
                        <div class="card-header">
                            <h3>Edit Product Images</h3>
                        </div>
                        <div class="card-body">
                            @if (count($productimages) == 0)
                                No Images yet.
                            @else
                            <div class="row">
                                @foreach ($productimages as $image)

                                    <div class="col-md-4 text-center mb-3">
                                        <div class="wrapp">
                                            <a href="{{Storage::disk('uploads')->url($image->images)}}" target="_blank" >
                                                <img src="{{Storage::disk('uploads')->url($image->images)}}" style="max-height: 150px;">
                                                <form action="{{route('admin.deleteproductimage', $image->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" data-id="{{ $image->id }}" class="remove" title="Remove">x</button>
                                                </form>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{route('admin.addmoreproductimages', $product->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-6 mt-5">
                                                <div class="form-group">
                                                    <label for="images">Add product images (Multiple images can be selected):</label>
                                                    <input type="file" class="form-control" name="images[]" multiple>
                                                    @error('images')
                                                        <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-success form-control">Add</button>
                                            </div>
                                    </form>
                                </div>
                            </div>

                            @endif
                        </div>
                    </div> --}}
                </div>
            </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

    <script>
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });
    </script>

<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
    $(document).ready(function() {
    $('.summernote').summernote({
        placeholder: 'Details about the product....',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ]
    });
    });
</script>
@endpush


