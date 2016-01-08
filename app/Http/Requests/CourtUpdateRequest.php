<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CourtUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        if ($user->hasRole('admin'))
        {
            return true;
        }

        abort(401, 'Unauthorized action.');

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'   => 'required|in:simple,double',
            'number' => 'required|integer|unique:courts,number,' . $this->route()->getParameter('court_id') . ',id',
        ];
    }
}
