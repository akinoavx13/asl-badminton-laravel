<?php

namespace App\Http\Requests;

class SettingUpdateRequest extends Request
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
            'cestas_sport_email' => 'required|email',
            'web_site_email'     => 'required|email',
            'web_site_name'      => 'required',
            'cc_email'           => 'required|email',
            'can_buy_t_shirt'    => 'required|boolean',
            'can_enroll'         => 'required|boolean',
        ];
    }
}
