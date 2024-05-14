<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'section_name'=>'required|unique:sections|max:50',
            'description'=>'required',
        ];
    }
    public function messages(){
        return [
            'section_name.required' => 'هذا اسم القسم مطلوب',
            'section_name.unique' => 'هذا اسم القسم موجود بالفعل',
            'section_name.max' => 'اسم القسم يجب ان يكون اصغر من 50 حرف',
            'description.required' => 'هذا الوصف مطلوب',
        ];
    }
}
