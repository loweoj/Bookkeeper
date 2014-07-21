<?php

class StreamsController extends \BaseController {

    public function __construct()
    {
        $this->streams = Stream::all();
    }

    /**
     * Display a listing of the resource.
     * GET /streams
     *
     * @return Response
     */
    public function index()
    {
        $streams  = $this->streams;

        return View::make('settings.streams.list')
            ->with(compact('streams'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /streams
     *
     * @return Response
     */
    public function store()
    {
        $stream = new Stream(Input::all());

        if ($stream->save())
        {
            if( Request::ajax() )
            {
                $renderedView = View::make('settings.streams.singleRow')->with(compact('stream'))->render();
                return Response::json(['success' => true, 'payload' => $renderedView]);
            }

            Session::flash('success', 'Stream created successfully!');

            return Redirect::action('CategoriesController@index');
        }

        return Redirect::back()->withInput()->withErrors($stream->getErrors());
    }

    /**
     * Update the specified resource in storage.
     * POST /streams/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $stream = Stream::find($id);

        if ($stream->update(Input::all()))
        {
            if( Request::ajax() )
            {
                $renderedView = View::make('settings.streams.singleRow')->with(compact('stream'))->render();
                return Response::json(['success' => true, 'payload' => $renderedView]);
            }

            Session::flash('success', 'Stream created successfully!');

            return Redirect::action('CategoriesController@index');

        }

        return Redirect::back()->withInput()->withErrors($stream->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     * POST /streams/delete/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        $stream = Stream::find($id);
        $stream->delete();
        return Redirect::back();
    }

}