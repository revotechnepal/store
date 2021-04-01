<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PosSales;
use App\Models\Product;
use Illuminate\Http\Request;

class PosSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::latest()->get();
        $foodcategory = Category::where('slug', 'food')->first();
        $beautycategory = Category::where('slug', 'beauty')->first();
        $grocerycategory = Category::where('slug', 'grocery')->first();
        $fooditems = [];
        foreach ($products as $product) {
            if(in_array($foodcategory->id, $product->categories)){
                array_push($fooditems, $product);
            }
        }
        $beautyitems = [];
        foreach ($products as $product) {
            if(in_array($beautycategory->id, $product->categories)){
                array_push($beautyitems, $product);
            }
        }
        $groceryitems = [];
        foreach ($products as $product) {
            if(in_array($grocerycategory->id, $product->categories)){
                array_push($groceryitems, $product);
            }
        }
        return view('backend.POS.create', compact('products', 'fooditems', 'groceryitems', 'beautyitems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosSales  $posSales
     * @return \Illuminate\Http\Response
     */
    public function show(PosSales $posSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PosSales  $posSales
     * @return \Illuminate\Http\Response
     */
    public function edit(PosSales $posSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PosSales  $posSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosSales $posSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PosSales  $posSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(PosSales $posSales)
    {
        //
    }
}
