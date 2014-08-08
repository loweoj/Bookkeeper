<?php  namespace Bookkeeper\Service\Form\UploadAttachment;

use Attachment;
use Bookkeeper\Image\Image;
use Bookkeeper\Service\Form\AbstractValidableForm;
use Bookkeeper\Service\Validation\ValidableInterface;
use Config;
use Input;

class UploadAttachmentForm extends AbstractValidableForm {

    /**
     * @var Image
     */
    private $image;

    public function __construct(ValidableInterface $validator, Image $image)
    {

        $this->validator = $validator;
        $this->image = $image;
    }

    public function attach($record, $input)
    {
        if ( ! $this->valid($input)) {
            return false;
        }

        // Get the file
        $file = Input::file('file');
        $dir = Config::get('image.upload_dir');

        $orig_filename = $file->getClientOriginalName();

        // Attempt to upload the file.
        if ($filePath = $this->image->upload($file, $dir)) {

            $attachmentData = [
                'filepath'      => $filePath,
                'record_id'     => $record->id,
                'original_name' => $orig_filename
            ];

            // Create the thumbnail
            if ($thumbPath = $this->image->createThumbnail($filePath)) {
                $attachmentData['thumbpath'] = $thumbPath;
            }

            // Save the attachment
            $attachment = new Attachment($attachmentData);

            // Attempt to save the attachment
            if ( ! $attachment->save()) {
                // Merge attachment errors onto any previous errors we have
                $this->errors()->merge($attachment->getErrors());

                return false;
            }

            return true;
        }

        $this->errors()->add('file', 'Could not upload file to target path');

        return false;
    }
}