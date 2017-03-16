<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveClichesOfTheDay extends FormRequest
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
        $rules = [];

        foreach($this->request->get("cotd") as $clicheId => $val)
        {
            foreach($val as $key => $cotd)
            {
                $rules["cotd." . $clicheId . ".date"] = 'date';
                $rules["cotd." . $clicheId . ".note"] = 'max:1000';
            }
        }

        return $rules;
    }
}
