<?php

namespace App\Http\Controllers;

use App\Models\sections;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProductsController extends Controller
{
    function __construct()
{
  $this->middleware('permission:المنتجات', ['only' => ['index']]);
  $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
  $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
  $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections:: all();
        $prodects = Products:: all();
        return view('products.product' , compact('sections', 'prodects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Product_name' => ['required','max:50',Rule::unique('products')],
            'section_id' => 'required',
            'description' => 'required',
        ],[
            'Product_name.required' =>'يرجى إدخال اسم المنتج',
            'section_id.required' =>'برجاح اختيار القسم',
            'Product_name.max' =>'اسم المنتج اكبر من 50 حرف ',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقاً',
        ]);

        Products::create([
            'product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'desciption' => $request->description,
        ]);
        Session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $ids = $request->pro_id;
        $request->validate([
            'Product_name' => ['required','max:50',Rule::unique('products')->ignore($ids)],
            'section_name' => 'required',
        ],[
            'Product_name.required' =>'يرجى إدخال اسم المنتج',
            'section_name.required' =>'يرجى اختيار اسم القسم',
            'Product_name.max' =>'اسم المنتج اكبر من 50 حرف ',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقاً',
        ]);


        $id = sections::where('section_name', $request->section_name)->first()->id;

        $Products = Products::findorFail($ids);
        // return $Products;
 
        $Products->update([
        'product_name' => $request->Product_name,
        'desciption' => $request->description,
        'section_id' => $id,
        ]);


        Session()->flash('Edit', 'تم التعديل المنتج بنجاح ');
        return redirect()->route('product.index');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->pro_id;
        Products::findorfail($id)->delete();
        Session()->flash('Error', 'تم حذف المنتج بنجاح ');
        return redirect()->route('product.index');
    }
}
