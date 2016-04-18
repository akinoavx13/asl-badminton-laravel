<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SeriesUpdateRequest extends Request
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
            'category'              => 'required',
            'display_order'         => 'required',
            'name'                  => 'required',
            'number_matches_rank_1' => 'required',
            'number_rank'           => 'required',
        ];
    }
}
