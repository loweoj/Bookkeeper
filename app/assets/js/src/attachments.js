if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.Attachments = function()
{
    var init = function()
    {
        $('.js-record-table').on('click', '.js-add-attachment', loadModalData);
        $('.js-record-table').on('mouseenter mouseleave', '.has-attachment, .attachment-thumb', toggleAttachmentThumb);
    };

    var loadModalData = function()
    {
        id = $(this).parents('tr').attr('id');
        $attachmentForm = $('#addAttachmentModal').find('form');
        newAction = replaceUrlVars($attachmentForm.attr('action'), {id: id});
        $attachmentForm.attr('action', newAction);
    };

    var replaceUrlVars = function(url, vars)
    {
        return url.replace(/{([A-Za-z0-9_\-]+)}/, function(match, p1, offset, string){
            return vars[p1];
        });
    };

    var toggleAttachmentThumb = function(e)
    {
        $(this).find('.attachment-thumb').fadeToggle(200);
    };

    return {
        init: init
    };
}();

if (typeof(jQuery)!='undefined') {
    jQuery(function($) {
        BookKeeper.UI.Attachments.init();
    });
}