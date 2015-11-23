<?php  namespace Bookkeeper\Import\Transformer;

use Str;

/**
 * INCOMPLETE CLASS
 * Currently copied from OfxTransformer.
 * I think we can rain-check this implementation until such a need for csv
 * import arises and we have more "base" functionality sorted...
 */
class CsvTransformer implements ImportTransformerInterface {

    /**
     * Create a unified array from the parsed data
     *
     * @param $data
     * @return mixed
     */
    public function transform($data, $map = null)
    {
        if( $map == null ) {
            throw new \InvalidArgumentException('CsvTransformer::transform requires a valid map object');
        }

        $return = [];

        foreach($data->BankAccounts as $i => $account)
        {
            $return[$i] = $this->getAccountDetails($account->accountNumber);
            $return[$i]['transactions'] = [];
            foreach($account->Statement->transactions as $transaction) {
                $return[$i]['transactions'][] = [
                    'date'        => $transaction->date->format('Y-m-d H:i:s'),
                    'payee'       => $transaction->name,
                    'amount'      => $transaction->amount,
                    'type'        => $transaction->type,
                    'description' => $transaction->memo,
                ];
            }
        }

        return $return;
    }

    /**
     * Retrieve Sort Code and Account Number if merged
     *
     * @param $accountNumber
     * @return array
     */
    public function getAccountDetails($accountNumber)
    {
        $sortCode = '';
        if(Str::length($accountNumber) > 8) {
            $sortCode = substr($accountNumber, 0, 6);
            $accountNumber = str_replace($sortCode, '', $accountNumber);
        }
        return [
            'account-number' => (string) $accountNumber,
            'sort-code'      => $sortCode
        ];
    }

}