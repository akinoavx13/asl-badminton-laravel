<?php

namespace App\Http\Requests;

class TournamentStoreRequest extends Request
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
            'start'         => 'required|date_format:d/m/Y',
            'end'           => 'required|after:start|date_format:d/m/Y',
            'name'          => 'required',
            'series_number' => 'required|numeric|min:1',
        ];
    }
}
