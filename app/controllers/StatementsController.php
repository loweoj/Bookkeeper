<?php

use Bookkeeper\Commanding\Base\CommandBus;
use Bookkeeper\Service\Form\ImportStatement\ImportStatementForm;

class StatementsController extends \BaseController {

    /**
     * @var CommandBus
     */
    // private $commandBus;

    /**
     * @var ImportStatementForm
     */
    private $importForm;

    public function __construct(ImportStatementForm $importForm )
	{
//		$this->commandBus = $commandBus;
        $this->importForm = $importForm;
    }

	/**
	 * Display a listing of the resource.
	 * POST /statements/import
	 *
	 * @return Response
	 */
	public function import()
	{
//		$file = Input::file('file');

        if( $this->importForm->import(Input::all()) )
        {
            return Redirect::route('statements.import')->with('status', 'success');
        }

        return Redirect::back()
            ->withInput()
            ->withErrors( $this->importForm->errors() )
            ->with('status', 'error');

//		if( $file->isValid() ) {
//             $this->commandBus->execute(
//             	new ImportStatementCommand($file)
//             );
//             return Redirect::home();
//		}
		return Response::json('error', 400);
	}

	/**
	 * Return all transactions paged.
	 */
	public function all()
	{

	}


	/**
	 * Store a
	 * GET /statements/create
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /statements
	 *
	 * @return Response
	 */
	public function store()
	{
	}

	/**
	 * Display the specified resource.
	 * GET /statements/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /statements/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /statements/{id}
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
	 * DELETE /statements/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}