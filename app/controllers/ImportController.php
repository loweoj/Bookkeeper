<?php

use Bookkeeper\Import\Translator\ImportTranslator;
use Bookkeeper\Service\Form\ImportStatement\ImportStatementForm;
use Bookkeeper\Rules\RuleManager;

class ImportController extends \BaseController {

    /**
     * @var ImportStatementForm
     */
    private $importForm;

    /**
     * @var ImportTranslator
     */
    private $translator;

    /**
     * @var RuleManager
     */
    private $ruleManager;

    public function __construct(ImportStatementForm $importForm, ImportTranslator $translator, RuleManager $ruleManager)
    {
        $this->importForm = $importForm;
        $this->translator = $translator;
        $this->ruleManager = $ruleManager;
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

            // If the current file is CSV, we need to display the mappings
            // form so that we can transform the parsed data properly.
            if ($this->translator->getCurrentExtension() == 'csv') {
                // return with CSV data mapping form.
            }

            $csvMap = null;
            $bankAccounts = $this->translator->makeAccountsArray($parsedData, $csvMap);


            $bankRepo = App::make('Bookkeeper\Repo\BankAccount\BankAccountInterface');
            $recordRepo = App::make('Bookkeeper\Repo\Record\RecordInterface');

            foreach($bankAccounts as $i => $account)  {
                if( $bankAccount = $bankRepo->findOrCreateWithTransactions($account) ) {
                    // Make draft records
                    $draftRecords = $this->ruleManager->run($account['transactions']);
                    // create draft records!
                    // $recordRepo->createDraftRecordsForAccount($draftRecords, $bankAccount->id);
                } else {
                    // Do some error messaging?!

                    break;
                }
            }

//            return View::make('transactions.list')
//                       ->with('transactions', $draftRecords)
//                       ->with('categories', $categories);
        }

        return Redirect::route('transactions.index')
                       ->withInput()
                       ->withErrors($this->importForm->errors())
                       ->with('status', 'error');
        // return Response::json('error', 400);
    }
}