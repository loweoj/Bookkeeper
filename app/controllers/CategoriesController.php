<?php

class CategoriesController extends \BaseController {

    public function __construct()
    {
        $this->categories = Category::orderBy('code', 'ASC')->get();

        // Allow CORS
//        $this->afterFilter(function ($route, $request, $response) {
//            $response->headers->set('Access-Control-Allow-Origin', '*');
//            return $response;
//        });
    }

	/**
	 * Display a listing of the resource.
	 * GET /categories
	 *
	 * @return Response
	 */
	public function index()
	{
        // Get all categories by code
        $categories  = $this->categories;
        $nextCode = count($categories) > 0 ? (int) $categories->last()->code : "001";
        $nextCode = sprintf("%03d", $nextCode + 1);

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
                $renderedView = View::make('settings.categories.singleRow')->with(compact('category'))->render();
                return Response::json(['success' => true, 'payload' => $renderedView]);
            }

            Session::flash('success', 'Category created successfully!');

            return Redirect::action('CategoriesController@index');
        }

        return Redirect::back()->withInput()->withErrors($category->getErrors());
	}

	/**
	 * Update the specified resource in storage.
	 * POST /categories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $category = Category::find($id);

        if ($category->update(Input::all()))
        {
            if( Request::ajax() )
            {
                $renderedView = View::make('settings.categories.singleRow')->with(compact('category'))->render();
                return Response::json(['success' => true, 'payload' => $renderedView]);
            }

            Session::flash('success', 'Category created successfully!');

            return Redirect::action('CategoriesController@index');

        }

        return Redirect::back()->withInput()->withErrors($category->getErrors());
	}

	/**
	 * Remove the specified resource from storage.
	 * POST /categories/delete/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
        $category = Category::find($id);
        $category->delete();
        return Redirect::back();
	}

}