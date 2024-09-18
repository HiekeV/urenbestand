<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'financial_year' => ['required'],
            'week' => ['required'],
            'date' => ['required'],
            'employee_number' => ['required'],
            'hours' => ['required'],
            'hour_code' => ['required'],
        ];
    }
}