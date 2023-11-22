<?php

namespace App\Http\Controllers;

use App\Models\PerformanceCategory;
use Illuminate\Http\Request;

class PerformanceCategoryController extends Controller
{
    function __construct(){
        $this->middleware('permission:category-management-access', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PerformanceCategory::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'category' => 'required',
        'colour' => 'required',
    ]);
    
    $category = new PerformanceCategory;

    $category->category = $request->category;
    $category->colour = $request->colour;

    $category->save();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerformanceCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceCategory $category)  
    {
    $request->validate([
        'category' => 'required',
        'colour' => 'required'
    ]);

    $category->category = $request->category;
    $category->colour = $request->colour;

    $category->save();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceCategory $category)
    {
    $category->delete();

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category deleted');
    }
}
