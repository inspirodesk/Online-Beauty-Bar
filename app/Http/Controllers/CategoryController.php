<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mews\Purifier\Facades\Purifier;

class CategoryController extends Controller
{
    /**
     * Instantiate a new NewsController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('permission:create-category|edit-category|delete-category', ['only' => ['index','show']]);
       $this->middleware('permission:create-category', ['only' => ['create','store']]);
       $this->middleware('permission:edit-category', ['only' => ['edit','update']]);
       $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
    */
    public function index(): View
    {
        return view('categories.index', 
            ['categories' => Category::latest()->paginate(10)]
        
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
{
    

    $category = new Category($request->all());

    $category->save();
    if ($request->ajax()) {
     
        return response()->json(['id' => $category->id]);
    } else {
   
        return redirect()->route('categories.index')
            ->withSuccess('New site is added successfully.');
    }
}


    /**
     * Display the specified resource.
     */
    public function show($category): View
    {
        $category = Category::find($category);
      
        
        return view('categories.show_modal', [
            'categories' => $category,
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category): View
{
    $category = Category::find($category);
   

    return view('categories.edit', [
        'category' => $category,
       
    ]);
}

    


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $categoryId): RedirectResponse
{
    $category = Category::find($categoryId);

    $category->update($request->all());


    $category->save();

    return redirect()->back()
        ->withSuccess('category is updated successfully.');
}


  
  
    public function destroy($id): RedirectResponse
{
    $category = Category::find($id);

    if (!$category) {
        return redirect()->route('categories.index')->withError('Site not found.');
    }

    $category->news()->detach(); 


    $category->delete();

    return redirect()->route('categories.index')->withSuccess('Site and related relationships are deleted successfully.');
}
}