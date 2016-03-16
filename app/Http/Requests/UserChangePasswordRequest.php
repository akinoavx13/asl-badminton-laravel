<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserChangePasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->route()->getParameter('user_id');
        $user = $this->user();

        if ($user->hasOwner($user_id) || $this->user()->hasRole('admin'))
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
            'password' => 'required|confirmed|min:6',
        ];
    }
}
