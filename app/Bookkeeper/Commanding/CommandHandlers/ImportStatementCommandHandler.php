<?php namespace Bookkeeper\Commanding\CommandHandlers;

use Bookkeeper\Commanding\Base\CommandHandler;

class ImportStatementCommandHandler implements CommandHandler {

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        dd($command);

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

                $transactions = $this->ruleManager->transform($ofx->BankAccount->Statement->transactions);

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
}