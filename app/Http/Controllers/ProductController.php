<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 10)){
            if ($request->ajax()) {
                $data = Product::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function ($row) {
                        $categories = $row->categories;
                        $categorys = '';
                        foreach ($categories as $category) {
                            $category_name = Category::where('id', $category)->first();
                            $categorys .= '<span class="badge bg-green">' . $category_name->name . '</span>' . ' ';
                        }
                        return $categorys;
                    })
                    ->addColumn('image', function($row){
                        $src = Storage::disk('uploads')->url($row->image);
                        $image = "<img src='$src' style='max-height: 100px;'>";
                        return $image;
                    })
                    ->addColumn('unit_price', function($row){
                        $unit_price = 'Rs. '.$row->unit_price;
                        return $unit_price;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.product.edit', $row->id);
                        $showurl = route('admin.product.show', $row->id);
                        $deleteurl = route('admin.product.destroy', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "<a href='$showurl' class='edit btn btn-info btn-sm'>Show</a>
                                <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                               <form action='$deleteurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='DELETE' />
                                   <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                               </form>
                               ";

                                return $btn;
                    })
                    ->rawColumns(['category', 'unit_price', 'image', 'action'])
                    ->make(true);
            }
            return view('backend.products.index');
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(checkpermission(Auth::user()->role_id, 11)){
            $categories = Category::latest()->get();
            return view('backend.products.create', compact('categories'));
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'product_name' => 'required',
            'categories' => 'required',
            'unit_price' => 'required|numeric',
            'variant' => 'required',
            'quantity' => 'required',
            'description' => '',
            'images' => 'required|mimes:jpg,jpeg,png'
        ]);



        $imagename = '';
        if($request->hasfile('images')){
            $images = $request->file('images');
            $imagename = $images->store('product_images', 'uploads');

            $product = Product::create([
                'name' => $data['product_name'],
                'categories' => $data['categories'],
                'unit_price' => $data['unit_price'],
                'info' => $data['variant'],
                'stock' => $data['quantity'],
                'image' => $imagename
            ]);
            $product->save();

            return redirect()->route('admin.product.index')->with('success', 'Product Information saved successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findorFail($id);
        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findorFail($id);
        $categories = Category::latest()->get();
        return view('backend.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'product_name' => 'required',
            'categories' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required|numeric',
            'variant' => 'required',
            'images' => 'mimes:jpg,jpeg,png'
        ]);

        $product = Product::findorFail($id);

        $imagename = '';
        if($request->hasfile('images')){
            Storage::disk('uploads')->delete($product->image);
            $images = $request->file('images');
            $imagename = $images->store('product_images', 'uploads');


            $product->update([
                'name' => $data['product_name'],
                'categories' => $data['categories'],
                'unit_price' => $data['unit_price'],
                'info' => $data['variant'],
                'stock' => $data['quantity'],
                'image' => $imagename
            ]);
        }else {
            $product->update([
                'name' => $data['product_name'],
                'categories' => $data['categories'],
                'unit_price' => $data['unit_price'],
                'info' => $data['variant'],
                'stock' => $data['quantity'],
            ]);
        }

        return redirect()->route('admin.product.index')->with('success', 'Product Information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorFail($id);
        Storage::disk('uploads')->delete($product->image);
        $product->delete();

        return redirect()->back()->with('success', 'Product Information Deleted successfully.');
    }


    // public function deleteproductimage($id)
    // {
    //     $productimage = ProductImages::findorFail($id);
    //     Storage::disk('uploads')->delete($productimage->images);
    //     $productimage->delete();

    //     return redirect()->back()->with('success', 'Product Image deleted successfully.');
    // }

    // public function addmoreproductimages(Request $request, $id)
    // {
    //     $this->validate($request, [
    //         'images' => 'required',
    //         'images.*' => 'required|mimes:jpg,jpeg,png',
    //     ]);

    //     $imagename = '';
    //     if($request->hasfile('images')){
    //         $images = $request->file('images');
    //         foreach($images as $image){
    //             $imagename = $image->store('product_images', 'uploads');

    //             $productimage = ProductImages::create([
    //                 'product_id' => $id,
    //                 'images' => $imagename,
    //             ]);
    //             $productimage->save();
    //         }
    //     }
    //     return redirect()->back()->with('success', 'Product Images added successfully.');
    // }
}
