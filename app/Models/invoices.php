<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\sections;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $fillable = ['invoice_number', 'invoice_Data', 'due_data', 'product', 'section', 'discount', 'rate_vat', 'value_vat', 'total', 'status', 'value_status', 'note', 'user'];
    protected $guarded=[];
    public function section()
    {
        return $this->belongsTo(sections::class);
    }
}
