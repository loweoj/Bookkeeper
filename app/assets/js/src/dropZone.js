if (typeof(BookKeeper) == 'undefined') {
    BookKeeper = {};
    BookKeeper.UI = {};
}

BookKeeper.UI.DropZone = function () {
    var init = function () {
        initDropzone();
    };

    var initDropzone = function () {

        $dropzone = $('.fileDropZone');

        if ($dropzone.dropzone) return;

        $dropzone.dropzone({
            clickable: true,
            dictDefaultMessage: 'Drop files here or click to upload',
            uploadMultiple: false,
            totaluploadprogress: function (p) {
                if (p == 100) {
                    // this.removeAllFiles();

                    // Hide currently active modal
                    $('.modal.in').modal('hide');

                    // Publish some event
                    // $.publish('dropzone.upload.success');

                    // reloadTransactions();
                }
            },
            fallback: function () {
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

if (typeof(jQuery) != 'undefined') {
    jQuery(function ($) {
        BookKeeper.UI.DropZone.init();
    });
}