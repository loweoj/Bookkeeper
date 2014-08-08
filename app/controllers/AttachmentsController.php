<?php

use Bookkeeper\Repo\Attachment\AttachmentInterface;

class AttachmentsController extends \BaseController {
    /**
     * @var AttachmentInterface
     */
    protected $attachment;

    public function __construct(AttachmentInterface $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Store a newly created resource in storage.
     * POST /records
     *
     * @return Response
     */
    public function store()
    {
        $attachment = new Attachment(Input::all());

        if ($attachment->save()) {
//            if (Request::ajax()) {
//                $categories = $this->category->getDropdownArray('expense');
//                $streams = $this->stream->getDropdownArray();
//                $renderedRow = View::make('records.table.singleRow')->with(compact('record', 'categories', 'streams'))->render();
//
//                return Response::json(['success' => true, 'payload' => $renderedRow]);
//            }

            Session::flash('success', 'Record created successfully!');

            return Redirect::route($record->type . '.index');
        }

        return Redirect::back()->withInput()->withErrors($attachment->getErrors());
    }
}