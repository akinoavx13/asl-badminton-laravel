<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use File;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{

    public static function routes($router) {
        $router->pattern('user_id', '[0-9]+');

        $router->get('{user_id}', [
            'uses' => 'ImageController@show',
            'as'   => 'image.show',
        ]);
    }

    public function show($user_id) {

        $path = public_path() . '/img/avatars/' . $user_id . '.png';

        if (File::exists($path)) {
            $img = Image::make($path)->response('png');

            return $img;
        }

        return abort(404);

    }
}
