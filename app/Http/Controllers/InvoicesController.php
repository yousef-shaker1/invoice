<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\invoices;
use App\Models\Products;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Mail\create_invoices;
use App\Notifications\sendmail;
use App\Models\invoices_details;
use Illuminate\Support\Facades\DB;
use App\Notifications\Add_invoices;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
 
use App\Http\Requests\InvoiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicesController extends Controller
{

    function __construct()
    {
    $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
    $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    $this->middleware('permission:طباعةالفاتورة', ['only' => ['print']]);
    $this->middleware('permission:ارشفة الفاتورة', ['only' => ['archef']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections:: all();
        $invoices = invoices:: all();
        return view('invoices.invoices', compact('invoices', 'sections'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = sections:: all();
        return view('invoices.add_invoices', compact('sections'));
        //
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'prodect' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        
        if ($request->hasFile('pic')) {
            
            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            
            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();
            
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);

            $user = User::first();
            $create = Auth()->user()->name;
            Mail::to(Auth::user()->email)->send(new create_invoices($create, $invoice_id));
            $user = User::where('id','!=', Auth()->user()->id)->get();
            $invoices = Invoices::latest()->first();
            Notification::send($user, new Add_invoices($invoices));
            Session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
            return back();
        }
    }
    /** 
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = invoices:: where('id', $id)->first();
        return view('invoices.status_show', compact('invoices'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sections = sections::all();
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.edit', compact('sections', 'invoices'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoices = invoices::findOrFail($id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'prodect' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        Session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect()->back();
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->invoice_id;
        $invoices = invoices::where('id', $ids)->forceDelete();
        $attachments = invoices_attachments::where('invoice_id', $ids)->get();
        if(!empty($attachments->invoice_number)){
            Storage::disk('public_upload')->deleteDirectory($attachments->invoice_number);
        }
        Session()->flash('delete', 'تم حذف الفاتورة بنجاح');
        return redirect()->back();
    }
    
    
    public function getprodecteds($id){
        $products = DB::table('products')->where('section_id', $id)->pluck("id", "product_name");
        return response()->json($products);
    }
    
    public function status_update(Request $request, $id){
        $invoices = invoices::findorfail($id);
        if ($request->Status == 'مدفوعة'){
            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
            
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        Session()->flash('update', 'تم تحديث الفاتورة بنجاح');
        return redirect()->back();
    }
    
    public function invoice_paid(){
        $invoices = invoices:: where('Value_Status',1)->get();
        return view('invoices.invoice_paid', compact('invoices'));
    }
    public function invoice_unpaid(){
        $invoices = invoices:: where('Value_Status',2)->get();
        return view('invoices.invoice_unpaid', compact('invoices'));
    }
    public function invoice_partial(){
        $invoices = invoices:: where('Value_Status',3)->get();
        return view('invoices.invoice_partial', compact('invoices'));
    }
    
    public function archef(Request $request){
        $ids = $request->invoice_id;
        $invoices = invoices::where('id', $ids)->delete();
        Session()->flash('delete', 'تم نقل الفاتورة الي الارشيف بنجاح');
        return redirect()->back();
    }
    public function archef_show(){
        $invoices = invoices:: onlyTrashed()->get();
        return view('invoices.archef', compact('invoices'));
    }
    public function restore(Request $request){
        $ids = $request->invoice_id;
        $invoices = invoices::withTrashed()->where('id', $ids)->restore();
        Session()->flash('restore', 'تم ارجاع البيانات بنجاح');
        return redirect()->back();
    }
    
    public function print($id){
        $invoices = invoices::where('id', $id)->first();
    return view("invoices.print_invoices", compact('invoices'));
    }

    public function MarkAsRead_all(){
        $user = User::findorfail(Auth()->user()->id);
        foreach ($user->unreadNotifications as $not){
            $not->markAsRead();
        }
        return redirect()->back();
    }
}
