<?php

use \OfxParser\Parser as OfxParser,
	\Laracasts\Commander\CommandBus,
	\Bookkeeper\Statements\ImportStatementCommand;


class StatementsController extends \BaseController {

	private $commandBus;

	private $ofxParser;

	public function __construct(CommandBus $commandBus, OfxParser $ofxParser)
	{
		$this->commandBus = $commandBus;
		$this->ofxParser = $ofxParser;
	}

	/**
	 * Display a listing of the resource.
	 * POST /statements/import
	 *
	 * @return Response
	 */
	public function import()
	{

		// $file = Input::file('file');

		// validate file

		// $this->commandBus->execute(
		// 	new ImportStatementCommand($file)
		// );
		// return Redirect::home();

		$file = Input::file('file');

		if( $file->isValid() ) {
			$directory = base_path('user_uploads/username');

			// Create the filename
			$filename = basename($file->getClientOriginalName(), '.ofx') . '_' . sha1(time()) . '.' . $file->getClientOriginalExtension();

			// Move the file
			$uploaded_file = $file->move($directory, $filename);

			if( $uploaded_file ) {
				// $this->fileParser->parseFile($uploaded_file);
				// Process OFX
				// $this->ofxHandler->process($uploaded_file);
				try {

					$ofx = $this->ofxParser->loadFromFile($uploaded_file);

                    // Create Statement
                    $newStatement = Statement::create([
                        'start_date' => $ofx->BankAccount->Statement->startDate,
                        'end_date' => $ofx->BankAccount->Statement->endDate
                    ]);

                    // Prepare transactions
					$insertTransactions = [];
                    foreach($ofx->BankAccount->Statement->transactions as $transaction) {
                        $insertTransactions[] = [
                            'date'      => $transaction->date->format('Y-m-d H:i:s'),
                            'payee'     => $transaction->payee,
                            'amount'    => $transaction->amount,
                            'type'      => $transaction->type,
                            'statement_id' => $newStatement->id,
                            'created_at' = new DateTime,
                            'updated_at' = new DateTime
                        ];
					}

                    // Create transactions in one fell swoop!
                    Transaction::insert($insertTransactions);

					return Response::json('success', 200);

				} catch (Exception $e) {
					// Could not find the file.
					print_r($e->getMessage());
					return Response::json($e->getMessage(), 400);
				}
			}
		}
		return Response::json('could not upload', 400);
	}

	/**
	 * Return all transactions paged.
	 * @return [type] [description]
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