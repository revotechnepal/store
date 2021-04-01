@extends('backend.layouts.app')

@section('content')
<div class="right_col" role="main">
        <h1>Product Information => {{$product->name}} <a href="{{route('admin.product.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Products</a></h1>
            <div class="row mt">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body mt-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="col-md-5">
                                        <b style="font-size: 15px;">Product Name:</b>
                                    </div>
                                    <div class="col-md-7">
                                        <p style="font-size: 15px;">{{$product->name}}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <b style="font-size: 15px;">Product Categories:</b>
                                    </div>
                                    <div class="col-md-7">
                                        @php
                                            $name = '';
                                            for ($i = 0 ; $i < count($product->categories) ; $i++) {
                                                $staff = DB::table('categories')->where('id', $product->categories[$i])->first();
                                                $name .= '<span class="badge bg-green"  style="font-size: 12px; margin-top: 5px;">' . $staff->name .'</span>&nbsp;';
                                            }
                                            echo $name;

                                        @endphp
                                    </div>
                                    <div class="col-md-5 mt-2">
                                        <b style="font-size: 15px;">Unit Price:</b>
                                    </div>
                                    <div class="col-md-7 mt-2">
                                        <p style="font-size: 15px;">Rs. {{$product->unit_price}}</p>
                                    </div>

                                    <div class="col-md-5">
                                        <b style="font-size: 15px;">In Stock:</b>
                                    </div>
                                    <div class="col-md-7">
                                        <p style="font-size: 15px;">{{$product->stock}}</p>
                                    </div>
                                    <div class="col-md-5">
                                        <b style="font-size: 15px;">Variant:</b>
                                    </div>
                                    <div class="col-md-7">
                                        <p style="font-size: 15px;">{{$product->info}}</p>
                                    </div>
                                    <a href="{{route('admin.product.edit', $product->id)}}" class="btn btn-primary mt-3">Edit Info</a>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="row">
                                        <a href="{{Storage::disk('uploads')->url($product->image)}}" target="_blank" >
                                            <img src="{{Storage::disk('uploads')->url($product->image)}}" style="max-height: 200px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

