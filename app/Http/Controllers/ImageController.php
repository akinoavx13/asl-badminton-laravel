<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use File;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{

    public static function routes($router) {
        $router->pattern('user_id', '[0-9]+');
        $router->pattern('actuality_id', '[0-9]+');
        $router->pattern('post_id', '[0-9]+');

        $router->get('/users/{user_id}', [
            'uses' => 'ImageController@userImage',
            'as'   => 'image.userImage',
        ]);

        $router->get('/actualities/{actuality_id}', [
            'uses' => 'ImageController@actualityImage',
            'as'   => 'image.actualityImage',
        ]);

        $router->get('/posts/{post_id}', [
            'uses' => 'ImageController@postImage',
            'as'   => 'image.postImage',
        ]);
    }

    public function userImage($user_id) {

        $path = public_path() . '/img/avatars/' . $user_id . '.jpg';

        if (File::exists($path)) {
            $img = Image::make($path)->response('jpg');

            return $img;
        }

        return Image::make(public_path() . '/img/anonymous.png')->response('png');

    }

    public function actualityImage($actuality_id) {

        $path = public_path() . '/img/actualities/' . $actuality_id . '.jpg';

        if (File::exists($path)) {
            $img = Image::make($path)->response('jpg');

            return $img;
        }

        return Image::make(public_path() . '/img/noImage.png')->response('png');
    }

    public function postImage($post_id) {

        $path = public_path() . '/img/posts/' . $post_id . '.jpg';

        if (File::exists($path)) {
            $img = Image::make($path)->response('jpg');

            return $img;
        }

        return Image::make(public_path() . '/img/noImage.png')->response('png');
    }
}
