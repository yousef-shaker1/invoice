<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Auth;;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentsController extends Controller
{

    function __construct()
    {
    $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // return $request;
        $request->validate([
            'file_name' => 'mimes:pdf,jpeg,png,jpg',
        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون pdf, jpeg, png, jpg',
        ]);
        $image = $request->file('file_name')->getClientOriginalName();
        // $path = $request->file('file_name')->store($image, 'public_upload');
        $attachments = invoices_attachments::create([
            'file_name' => $image,
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->id,
            'Created_by' => Auth::user()->name,
        ]);
        
        // move pic
        $invoiceNumber = $request->invoice_number;
        $imgPath = $invoiceNumber . '/' . $image;
        $img = Storage::disk('public_upload')->path($imgPath);
        
        
        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
//
    }


    /**
     * Display the specified resource.
     */
    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
