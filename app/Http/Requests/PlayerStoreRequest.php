<?php

namespace App\Http\Requests;

class PlayerStoreRequest extends Request
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
            'season_id'   => 'required|exists:seasons,id',
            'formula'     => 'required|in:leisure,fun,performance,corpo,competition',
            't_shirt'     => 'required_if:formula,leisure,fun,performance',
            'simple'      => 'required_if:formula,fun,performance,corpo,competition|boolean',
            'double'      => 'required_if:formula,fun,performance,corpo,competition|boolean',
            'mixte'       => 'required_if:formula,fun,performance,corpo,competition|boolean',
            'corpo_man'   => 'required_if:formula,corpo,competition|boolean',
            'corpo_woman' => 'required_if:formula,corpo,competition|boolean',
            'corpo_mixte' => 'required_if:formula,corpo,competition|boolean',
        ];
    }
}
