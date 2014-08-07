<?php

namespace Bookkeeper\Repo\Attachment;

interface AttachmentInterface {

    /**
     * Find a single attachment from ID
     *
     * @param $id
     * @return mixed
     */
    public function find($id);


    /**
     * Return all attachments
     *
     * @return mixed
     */
    public function all();

} 