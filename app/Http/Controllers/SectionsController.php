<?php

namespace App\Http\Controllers;

use App\Models\sections;
use App\Http\Requests\SectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class SectionsController extends Controller
{


    function __construct()
    {
    $this->middleware('permission:الاقسام', ['only' => ['index']]);
    $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        return view('sections.section', compact('sections'));
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
    public function store(SectionRequest $request)
    {
        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name),
        ]);

        Session()->flash('Add','تم اضافة القسم بنجاج');
        return redirect('/section');
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
 //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        
        $request->validate([
            'section_name' => ['required','max:255',Rule::unique('sections')->ignore($id)],
            'description' => 'required',
        ],[
            'section_name.required' =>'يرجى إدخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقاً',
            'description.required' =>'يرجى إدخال البيان',
        ]);

        $sections = sections::findorfail($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        Session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect()->route('section.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::findorfail($id)->delete();
        Session()->flash('delete','تم حذف القسم بنجاج');
        return redirect()->route('section.index');
    }
}
