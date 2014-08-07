if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.Attachments = function()
{
    var tableSelector = '.js-editable-table';
    var rowSelector = '.js-editable-row';
    var cellValueSelector = '.js-editable-value';

    var init = function()
    {
        initDropzone();
    };

    var initDropzone = function()
    {
        $('.dropzone').dropzone({
            clickable: true,
            dictDefaultMessage: 'Drop files here or click to upload',
            uploadMultiple: false,
            totaluploadprogress: function(p) {
                if (p==100) {
                    // this.removeAllFiles();
                    $('.modal.in').modal('hide');
                    // reloadTransactions();
                }
            },
            fallback: function(){
                // $.getScript(Perch.path+'/core/assets/js/jquery.form.min.js', function(){
                //     form.ajaxForm({
                //         beforeSubmit: function(){
                //             show_spinner();
                //         },
                //         success: function(r) {
                //             hide_spinner();
                //             close_asset_drop();
                //             reload_assets();
                //         }
                //     });
                // });

            },
            forceFallback: true, // useful for testing!
        });
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