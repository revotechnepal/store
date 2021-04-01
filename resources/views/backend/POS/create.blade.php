@extends('backend.layouts.app')

@section('content')
    <div class="right_col" role="main">
        <p style="font-size: 35px; font-weight: bolder;" class="text-center mt-2">Revo Store</p><hr>
        {{-- <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body" style="min-height: 500px;">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-products-tab" data-toggle="tab" href="#all-products" role="tab" aria-controls="all-products" aria-selected="true">All Products</a>
                            </li>
                            <li>
                                <a class="nav-link" id="food-tab" data-toggle="tab" href="#food" role="tab" aria-controls="food" aria-selected="false">Food Items</a>
                            </li>
                            <li>
                                <a class="nav-link" id="beauty-tab" data-toggle="tab" href="#beauty" role="tab" aria-controls="beauty" aria-selected="false">Beauty Items</a>
                            </li>
                            <li>
                                <a class="nav-link" id="grocery-tab" data-toggle="tab" href="#grocery" role="tab" aria-controls="grocery" aria-selected="false">Grocery Items</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="tab-pane fade active show" id="all-products" role="tabpanel" aria-labelledby="all-products-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-md-3">
                                            <a href="">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <img src="{{Storage::disk('uploads')->url($product->image)}}" alt="{{$product->name}}" style="max-height: 100px;">
                                                        <p class="text-center mt-2">
                                                            <b>{{$product->name}}</b> ({{$product->info}})<br>
                                                            <span class="text-center">Rs. {{$product->unit_price}}</span><br>
                                                            <span class="text-center">In stock: {{$product->stock}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="food" role="tabpanel" aria-labelledby="food-tab">
                                <div class="row">
                                    @foreach ($fooditems as $product)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <img src="{{Storage::disk('uploads')->url($product->image)}}" alt="{{$product->name}}" style="max-height: 100px;">
                                                    <p class="text-center mt-2">
                                                        <b>{{$product->name}}</b> ({{$product->info}})<br>
                                                        <span class="text-center">Rs. {{$product->unit_price}}</span><br>
                                                        <span class="text-center">In stock: {{$product->stock}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="beauty" role="tabpanel" aria-labelledby="beauty-tab">
                                <div class="row">
                                    @foreach ($beautyitems as $product)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body">

                                                    <img src="{{Storage::disk('uploads')->url($product->image)}}" alt="{{$product->name}}" style="max-height: 100px;">
                                                    <p class="text-center mt-2">
                                                        <b>{{$product->name}}</b> ({{$product->info}})<br>
                                                        <span class="text-center">Rs. {{$product->unit_price}}</span><br>
                                                        <span class="text-center">In stock: {{$product->stock}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="grocery" role="tabpanel" aria-labelledby="grocery-tab">
                                <div class="row">
                                    @foreach ($groceryitems as $product)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body">

                                                    <img src="{{Storage::disk('uploads')->url($product->image)}}" alt="{{$product->name}}" style="max-height: 100px;">
                                                    <p class="text-center mt-2">
                                                        <b>{{$product->name}}</b> ({{$product->info}})<br>
                                                        <span class="text-center">Rs. {{$product->unit_price}}</span><br>
                                                        <span class="text-center">In stock: {{$product->stock}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="min-height: 500px;">
                    <div class="card-header text-center">
                        Cart Details
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </thead>
                            </table>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        Sub Total
                                    </td>
                                    <td>
                                        Rs. 0
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Discount
                                    </td>
                                    <td>
                                        Rs. 0
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Grand Total
                                    </td>
                                    <td>
                                        Rs. 0
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <div id="app">
                    <example-component></example-component>
                </div>
            </div>
        </div>


    </div>
@endsection
