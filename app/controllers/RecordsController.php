<?php

use Bookkeeper\Repo\Category\CategoryInterface;
use Bookkeeper\Repo\Record\RecordInterface;
use Bookkeeper\Repo\Stream\StreamInterface;

class RecordsController extends \BaseController
{

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

    public function __construct(RecordInterface $record, CategoryInterface $category, StreamInterface $stream)
    {
        $this->record = $record;
        $this->category = $category;
        $this->stream = $stream;
    }

    public function showIncome()
    {
        $records = $this->record->byType('income')->all();
        $categories = $this->category->getDropdownArray('income');
        $streams = $this->stream->getDropdownArray();
        $type = 'income';

        return View::make('records.listIncome')
            ->with(compact('records', 'categories', 'streams', 'type'));
    }

    public function showExpenses()
    {
        $records = $this->record->byType('expense')->all();
        $categories = $this->category->getDropdownArray('expense');
        $streams = $this->stream->getDropdownArray();
        $type = 'expense';

        return View::make('records.listExpenses')
            ->with(compact('records', 'categories', 'streams', 'type'));
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
                $renderedRow = View::make('records.table.singleRow')->with(compact('record','categories','streams'))->render();

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
                $renderedRow = View::make('records.table.singleRow')->with(compact('record','categories','streams'))->render();

                return Response::json(['success' => true, 'payload' => $renderedRow]);
            }
            Session::flash('success', 'Record updated successfully!');
            return Redirect::route($record->type . '.index');
        }

        return Redirect::back()->withInput()->withErrors($record->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /records/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}