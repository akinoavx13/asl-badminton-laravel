<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Testimonial;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //index
        $router->get('index', [
            'uses' => 'TestimonialController@index',
            'as'   => 'testimonial.index',
        ]);

        $router->get('create', [
            'uses' => 'TestimonialController@create',
            'as'   => 'testimonial.create',
        ]);

        $router->post('create', [
            'uses' => 'TestimonialController@store',
            'as'   => 'testimonial.store',
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::select('users.forname', 'users.name', 'testimonials.content',
            'testimonials.created_at')
            ->join('users', 'users.id', '=', 'testimonials.user_id')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $testimonial = new Testimonial();

        return view('testimonial.create', compact('testimonial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TestimonialStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialStoreRequest $request)
    {

        if ($request->get('content') !== '<p><br></p>')
        {
            Testimonial::create([
                'user_id' => $this->user->id,
                'content' => $request->get('content'),
            ]);

            return redirect()->route('testimonial.index')->with('success', 'Le témoignage a bien été enregistré !');
        }
        else
        {
            return redirect()->back()->with('error', 'Le témoignage ne peut pas être vide !')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
