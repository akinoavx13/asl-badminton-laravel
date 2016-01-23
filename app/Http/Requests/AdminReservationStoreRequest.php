<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminReservationStoreRequest extends Request
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
            'start'       => 'date_format:d/m/Y|required',
            'title'       => 'required',
            'recurring'   => 'boolean|required',
            'end'         => 'required_if:recurring,1|date_format:d/m/Y|after:start',
            'day'         => 'required_if:recurring,1|in:monday,tuesday,wednesday,thursday,friday|array',
            'court_id'    => 'required|exists:courts,id|array',
            'timeSlot_id' => 'required|exists:time_slots,id|array',
        ];
    }
}
