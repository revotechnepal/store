<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 12))
        {
            if ($request->ajax()) {
                $data = Category::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $editurl = route('admin.category.edit', $row->id);
                        $deleteurl = route('admin.category.destroy', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                               <form action='$deleteurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='DELETE' />
                                   <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                               </form>
                               ";

                                return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('backend.category.index');
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
        return view('backend.category.create');
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
            'name' => 'required'
        ]);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($request['name']),
        ]);

        $category->save();
        return redirect()->route('admin.category.index')->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findorFail($id);
        return view('backend.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::findorFail($id);
        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($request['name']),
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorFail($id);

        $project = Project::where('category_id', $category->id)->get();

        if($project)
        {
            return redirect()->route('admin.category.index')->with('failure', 'Category is used in project. Cannot delete.');
        }
        else{
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
        }
    }
}
