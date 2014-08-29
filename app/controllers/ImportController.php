<?php

use Bookkeeper\Import\Translator\ImportTranslator;
use Bookkeeper\Service\Form\ImportStatement\ImportStatementForm;

class ImportController extends \BaseController {

    public function __construct(ImportStatementForm $importForm, ImportTranslator $translator)
    {
        $this->importForm = $importForm;
        $this->translator = $translator;
    }

    /**
     * Display a listing of the resource.
     * POST /statements/import
     *
     * @return Response
     */
    public function import()
    {
        $categories = [
            1 => 'Category One',
            2 => 'Category Two',
            3 => 'Category Three'
        ];

        if ($this->importForm->isValid(Input::all())) {

            $file = Input::file('file');

            // Parse the file
            $parsedData = $this->translator->parseInputFile($file);

            dd($parsedData);

            // If the current file is CSV, we need to display the mappings
            // form so that we can transform the parsed data properly.
            if ($this->translator->getCurrentExtension() == 'csv') {
                // return with CSV data mapping form.
            }

            $csvMap = null;
            $bankAccounts = $this->translator->makeAccountsArray($data, $csvMap);

            /*
            TransformedData
                $bankAccounts = array(
                    array(
                        'account-number' => '',
                        'account-sort-code' => '',
                        'transactions'  => array(
                            'date'        => $ofxTransaction->date->format('Y-m-d H:i:s'),
                            'payee'       => $ofxTransaction->name,
                            'amount'      => $ofxTransaction->amount,
                            'type'        => $ofxTransaction->type,
                            'description' => $ofxTransaction->memo
                        )
                    )
                )

                foreach($bankAccounts as $account)
                {
                    $draftRecords = $this->ruleManager->run($account['transactions']);

                }

             */





            // Create / Find Bank Account
            /**
             * Get Bank Account information from transactions
             * Find/Create bank account for each transaction.
             */

            $transactions = $this->importForm->getTransactions();

            return View::make('transactions.list')
                       ->with('transactions', $transactions)
                       ->with('categories', $categories);
        }

        return Redirect::route('transactions.index')
                       ->withInput()
                       ->withErrors($this->importForm->errors())
                       ->with('status', 'error');
        // return Response::json('error', 400);
    }
}