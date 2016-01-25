<?php

namespace App\Http\Requests;

use App\Helpers;
use App\Http\Requests\Request;

class PlayerReservationStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $player = Helpers::getInstance()->myPlayer();

        if ($player !== null)
        {
            if (! $player->hasFormula('leisure'))
            {
                return true;
            }
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
            'first_team'  => 'required|exists:teams,id',
            'second_team' => 'required|exists:teams,id|different:first_team',
        ];
    }
}
