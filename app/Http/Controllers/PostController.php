<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    /**
     * @param $router
     */
    public static function routes($router)
    {

        $router->pattern('actuality_id', '[0-9]+');
        $router->pattern('post_id', '[0-9]+');

        //home page
        $router->post('create/{actuality_id}', [
            'uses' => 'PostController@storeActualityPost',
            'as'   => 'post.storeActualityPost',
        ]);

        $router->get('delete/{post_id}', [
            'uses' => 'PostController@delete',
            'as'   => 'post.delete',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeActualityPost(Request $request, $actuality_id)
    {
        Post::create([
            'user_id'      => $this->user->id,
            'actuality_id' => $actuality_id,
            'content'      => nl2br($request->get('content')),
        ]);

        return redirect()->back()->with('success', 'Le commentaire est bien ajouté !');
    }

    public function delete($post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->delete();

        return redirect()->back()->with('success', "Le commentaire vient d'être supprimé !");
    }
}
