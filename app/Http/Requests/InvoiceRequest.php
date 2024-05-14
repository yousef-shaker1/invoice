<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'invoice_number' => 'required',
                'invoice_Date' => 'required|date',
                'Due_date' => 'required|date',
                'product' => 'required',
                'Section' => 'required',
                'Amount_collection' => 'required|max:8',
                'Amount_Commission' => 'required|max:8',
                'Discount' => 'required',
                'Value_VAT' => 'required',
                'Rate_VAT' => 'required',
                'Total' => 'required',
                'note' => 'nullable',
        ];
    }
}
