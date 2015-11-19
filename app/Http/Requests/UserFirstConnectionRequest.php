<?php

namespace App\Http\Requests;

use App\User;

class UserFirstConnectionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->route()->getParameter('user_id');
        $token_first_connection = $this->route()->getParameter('token_first_connection');
        $user = User::where('id', $user_id)->where('token_first_connection', $token_first_connection)->first();

        if ($user !== null && $user->hasFirstConnection('1'))
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
            'name'                => 'required',
            'forname'             => 'required',
            'email'               => 'unique:users,email|email',
            'password'            => 'confirmed|min:6',
            'birthday'            => 'required|date_format:d/m/Y',
            'tshirt_size'         => 'required|in:XXS,XS,S,M,L,XL,XXL',
            'gender'              => 'required|in:man,woman',
            'state'               => 'required|in:hurt,holiday,active,inactive',
            'lectra_relationship' => 'required|in:lectra,child,conjoint,external,trainee,subcontractor',
            'newsletter'          => 'required|in:0,1',
            'avatar'              => 'image',
            'ending_holiday'      => 'date_format:d/m/Y|required_if:active,holiday',
            'ending_injury'       => 'date_format:d/m/Y|required_if:active,hurt',
        ];
    }
}
