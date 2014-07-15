<?php

class CategoriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /categories
	 *
	 * @return Response
	 */
	public function index()
	{
        // Get all categories by code
        $categories = Category::orderBy('code', 'ASC')->get();

        // Get next available code
        $nextCode = count($categories) > 0 ? (int) $categories->last()->code + 1 : "001";
        $nextCode = sprintf("%03d", $nextCode);

		return View::make('settings.categories.list')
                ->with(compact('categories', 'nextCode'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /categories
	 *
	 * @return Response
	 */
	public function store()
	{
        $category = new Category(Input::all());

        if ($category->save())
        {
            if( Request::ajax() )
            {
                $renderedView = View::make('settings.categories.newAjaxRow')->with(compact('category'))->render();
                return Response::json(['success' => true, 'payload' => $renderedView]);
            }

            Session::flash('success', 'Category created successfully!');

            return Redirect::action('CategoriesController@index');

        }

        return Redirect::back()->withInput()->withErrors($category->getErrors());
	}


	/**
	 * Show the form for editing the specified resource.
	 * GET /categories/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $category = Category::find($id);

        $view = 'settings.categories.edit';

        return View::make($view)->with(compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /categories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /categories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}