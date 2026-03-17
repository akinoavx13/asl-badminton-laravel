<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RopeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        if (! $user->hasRole('ce'))
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
            //
            'tension'   => 'required',
            'type'      => 'required|in:BG65,BG65Ti,BG80,BG80Power,VBS77,VBS66',
        ];
    }
}
