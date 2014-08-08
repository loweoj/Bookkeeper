<?php

use Bookkeeper\Repo\Category\CategoryInterface;
use Bookkeeper\Repo\Record\RecordInterface;
use Bookkeeper\Repo\Stream\StreamInterface;
use Bookkeeper\Service\Form\UploadAttachment\UploadAttachmentForm;

class RecordsController extends \BaseController {

    /**
     * @var RecordInterface
     */
    private $record;

    /**
     * @var CategoryInterface
     */
    private $category;
    /**
     * @var StreamInterface
     */
    private $stream;
    /**
     * @var UploadAttachmentForm
     */
    private $attachmentForm;

    public function __construct(RecordInterface $record, CategoryInterface $category, StreamInterface $stream, UploadAttachmentForm $attachmentForm)
    {
        $this->record = $record;
        $this->category = $category;
        $this->stream = $stream;
        $this->attachmentForm = $attachmentForm;
    }

    public function showIncome()
    {
        $records = $this->record->byType('income')->all();
        $categories = $this->category->getDropdownArray('income');
        $streams = $this->stream->getDropdownArray();

        // Set the type for the add record form
        $type = 'income';

        // Title the page
        $recordTypeTitle = 'Income';

        return View::make('records.listRecords')
                   ->with(compact('records', 'categories', 'streams', 'type', 'recordTypeTitle'));
    }

    public function showExpenses()
    {
        $records = $this->record->byType('expense')->all();
        $categories = $this->category->getDropdownArray('expense');
        $streams = $this->stream->getDropdownArray();

        // Set the type for add record form
        $type = 'expense';

        // Title the page.
        $recordTypeTitle = 'Expenses';

        return View::make('records.listRecords')
                   ->with(compact('records', 'categories', 'streams', 'type', 'recordTypeTitle'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /records
     *
     * @return Response
     */
    public function store()
    {
        $record = new Record(Input::all());

        if ($record->save()) {
            if (Request::ajax()) {
                $categories = $this->category->getDropdownArray('expense');
                $streams = $this->stream->getDropdownArray();
                $renderedRow = View::make('records.table.singleRow')->with(compact('record', 'categories', 'streams'))->render();

                return Response::json(['success' => true, 'payload' => $renderedRow]);
            }

            Session::flash('success', 'Record created successfully!');

            return Redirect::route($record->type . '.index');
        }

        return Redirect::back()->withInput()->withErrors($record->getErrors());
    }

    /**
     * Update the specified resource in storage.
     * POST /records/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $record = $this->record->find($id);
        if ($record->update(Input::all())) {

            if (Request::ajax()) {
                $categories = $this->category->getDropdownArray('expense');
                $streams = $this->stream->getDropdownArray();
                $renderedRow = View::make('records.table.singleRow')->with(compact('record', 'categories', 'streams'))->render();

                return Response::json(['success' => true, 'payload' => $renderedRow]);
            }
            Session::flash('success', 'Record updated successfully!');

            return Redirect::route($record->type . '.index');
        }

        return Redirect::back()->withInput()->withErrors($record->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     * POST /records/{id}/attachment
     *
     * @param  int $id
     * @return Response
     */
    public function attach($recordId)
    {

        // Find the record
        $record = $this->record->find($recordId);

        if ( ! $record) {
            return Redirect::back()->withErrors(['record', 'Record not found with ID' . $recordId]);
        }

        if ($this->attachmentForm->attach($record, Input::all())) {

            if (Request::ajax()) {
                $categories = $this->category->getDropdownArray('expense');
                $streams = $this->stream->getDropdownArray();
                $renderedRow = View::make('records.table.singleRow')->with(compact('record', 'categories', 'streams'))->render();

                return Response::json(['success' => true, 'payload' => $renderedRow]);
            }

            Session::flash('success', 'Attachment added successfully!');

            return Redirect::route($record->type . '.index');
        }

        return Redirect::back()->withInput()->withErrors($this->attachmentForm->errors());
    }
}