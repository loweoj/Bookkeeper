<?php  namespace Bookkeeper\Service\Form\UploadAttachment;

use Bookkeeper\Service\Validation\AbstractLaravelValidator;

class UploadAttachmentLaravelValidator extends AbstractLaravelValidator {

    protected $rules = [
        'file' => 'required|mimes:pdf,jpg,jpeg,png,gif'
    ];

    protected $messages = [
        'file.mimes' => 'The attachment must be a pdf, jpg, jpeg, png or gif!'
    ];
} 