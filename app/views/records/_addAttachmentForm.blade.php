<div class="modal fade" id="addAttachmentModal" tabindex="-1" role="dialog" aria-labelledby="Import Statement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Attachment</h4>
            </div>
            <div class="modal-body">
                <form action="/records/{id}/attachment/" enctype="multipart/form-data" method="post" class="fileDropZone  attachment-dropzone" id="attachmentDrop">
                    <div class="fallback">
                        <input name="file" type="file" />
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->