<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invok = invoices_attachments::findorfail($request->id_file);
        $invok->delete();
        $disk = Storage::disk('public_upload')->delete($request->invoice_number.'/'.$request->file_name);
        Session()->flash('delete','تم الحذف بنجاح');
        return back();
    }

    public function invoice_details($id)
    {    
        $invoices = invoices::where('id',$id)->first();
        $details = invoices_details::where('id_Invoice',$id)->get();
        $attachments = invoices_attachments::where('invoice_number', $invoices->invoice_number)->get();
        $sections = sections::all();
        return view('invoices.invoice_details', compact('invoices', 'sections','details','attachments'));
    }
    public function open_file($invoice_number, $file_name){
        $files = Storage::disk('public_upload')->path($invoice_number . '/' . $file_name);
        return response()->file($files);
    }
    
    public function get_file($invoice_number, $file_name){

        $files = Storage::disk('public_upload')->path($invoice_number . '/' . $file_name);
        return response()->download($files); 
        // $contents= Storage::disk('public_upload')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        // return response()->download( $contents);
    }

    public function details_not($id){
        // $not_id = DB::table('notifications')->where('data->id' , $id)->where('notifiable_id', Auth::user()->id)->pluck('id');
        // DB::table('notifications')->where('id', $not_id)->update(['read_at' => '2024-05-10 03:28:49']);
    }
}
