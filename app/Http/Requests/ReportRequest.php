<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'area_id'        => ['required', 'exists:areas,id'],
        'judul'          => ['required', 'string', 'max:150'],
        'kondisi'        => ['required', 'string', 'min:10', 'max:1000'],
        'tingkat'        => ['required', 'in:ringan,sedang,berat'],
        'latitude'       => ['required', 'numeric', 'between:-90,90'],
        'longitude'      => ['required', 'numeric', 'between:-180,180'],
        'waktu_kejadian' => ['required', 'date', 'before_or_equal:now'],
    ];
}
}
