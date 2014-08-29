<?php namespace Bookkeeper\Import\Transformer;

interface ImportTransformerInterface {

    /**
     * Create a unified array from the parsed data
     *
     * Required Array format:
     * $bankAccounts = array(
     *      'account-number' => '',
     *      'sort-code' => '',
     *      'transactions'  => array(
     *          'date'        =>
     *          'payee'       =>
     *          'amount'      =>
     *          'type'        =>
     *          'description' =>
     *      )
     * )
     *
     * @param      $data
     * @param null $map Data map
     * @return mixed
     */
    public function transform($data, $map = null);
}