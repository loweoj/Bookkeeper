<?php

use Bookkeeper\Commanding\Base\CommandBus;
use Bookkeeper\Commanding\Commands\ImportStatementCommand;
use Bookkeeper\Import\Translator\ImportTranslator;
use Bookkeeper\Rules\RuleManager;
use Bookkeeper\Service\Form\ImportStatement\ImportStatementForm;
use Carbon\Carbon;

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
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(ImportStatementForm $importForm, ImportTranslator $translator, CommandBus $commandBus)
    {
        $this->importForm = $importForm;
        $this->translator = $translator;
        $this->commandBus = $commandBus;
    }

    /**
     * Display a listing of the resource.
     * POST /statements/import
     *
     * @return Response
     */

    /**
     * Handle a request to import transaction data
     * POST /statements/import
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function import()
    {
        $categories = [
            1 => 'Category One',
            2 => 'Category Two',
            3 => 'Category Three'
        ];

        $presetMappings = [
            1 => 'Preset One',
            2 => 'Preset Two'
        ];

        if ($this->importForm->isValid(Input::all())) {

            $file = Input::file('file');

            // Parse the file
            $parsedData = $this->translator->parseInputFile($file);

            // If the current file is CSV, we need to display the mappings
            // form so that we can transform the parsed data properly.
            if ($file->getClientOriginalExtension() == 'csv') {

                // $this->csvImporter->showMapForm();
                $key = 'csvData.'.md5(time().\Str::random());
                Cache::put($key, serialize($parsedData), Carbon::now()->addMinutes(10));
                Session::put('csvDataKey', $key);

//                if ( ! isset($parsedData['headers'])) {
//                    throw new \Exception('CSV Parser must return array(headers, lines)');
//                }

                $dbFields = [
                    'ignore'      => '(ignore)',
                    'amount'      => 'Amount',
                    'amountIncome'      => 'Amount (income only)',
                    'amountExpense'      => 'Amount (expense only)',
                    'date'        => 'Date',
                    'description' => 'Description',
                    'payee '      => 'Payee'
                ];

                $csvCols = $parsedData['headers'];

                return View::make('transactions.csvMap')
                           ->with(compact('presetMappings', 'categories', 'csvCols', 'dbFields'));
            }

            $bankAccounts = $this->translator->makeAccountsArray($parsedData);

            $draftRecords = $this->commandBus->execute(new ImportStatementCommand($bankAccounts));

            return Redirect::route('transactions.index');
        }

        return Redirect::route('transactions.index')
                       ->withInput()
                       ->withErrors($this->importForm->errors())
                       ->with('status', 'error');
    }


    public function csvImport()
    {
        // $this->csvMapForm->isValid(Input::all())
        if (true) {

            $cacheKey = Session::pull('csvDataKey');
            $data = Cache::pull($cacheKey);
            $data = unserialize($data);

            $map = Input::all();
            $bankAccounts = $this->translator->makeAccountsArray($data, $map);

            dd($bankAccounts);
        }

    }
}