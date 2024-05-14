<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sections;

class Products extends Model
{
    use HasFactory;
    protected $fillable = ['product_name','section_id', 'desciption'];

    public function section()
    {
        return $this->belongsTo(sections::class);
    }
    // public function invoices()
    // {
    //     return $this->belongsTo(invoices::class);
    // }
}
