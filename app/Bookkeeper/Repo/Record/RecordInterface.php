<?php namespace Bookkeeper\Repo\Record;

interface RecordInterface {

    /**
     * Return all income records
     * @return $this Record Repository
     */
    public function getIncome();

    public function getExpenses();

    public function all();

    public function find($id);

    public function byCategory($category);

    public function byPayee($payee);

    public function createDraftRecordsForAccount($draftRecords, $id);
}