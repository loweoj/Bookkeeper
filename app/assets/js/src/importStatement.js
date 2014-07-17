if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.ImportStatement = function()
{
    var tableSelector = '.js-editable-table';
    var rowSelector = '.js-editable-row';
    var cellValueSelector = '.js-editable-value';

    var init = function()
    {
        // initDropzone();
    };

    var initDropzone = function()
    {
        $('#statementImportDrop').dropzone({
            clickable: true,
            dictDefaultMessage: 'Drop files here or click to upload',
            uploadMultiple: false,
            totaluploadprogress: function(p) {
                if (p==100) {
                    this.removeAllFiles();
                    $('#importStatementModal').modal('hide');
                    reloadTransactions();
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

    var getTransactions = function()
    {
        // var cb = function(callback) {
        //     return function(result) {
        //         last_request_page = current_page;
        //         if (result.assets.length) {
        //             var i, l;
        //             for(i=0, l=result.assets.length; i<l; i++) {
        //                 asset_index[result.assets[i].id] = result.assets[i];
        //             }
        //             current_page++;
        //         }
        //         callback(result);
        //         function (data) {
        //             if (current_opts['view'] && current_opts['view']=='list') {
        //                 var template = Handlebars.templates['asset-list'];
        //             }else{
        //                 var template = Handlebars.templates['asset-grid'];
        //             }
        //             var target = $('.asset-field .inner');
        //             target.find('.notice').remove();
        //             hide_spinner();
        //             if (current_page>1 && !data.assets.length) return;
        //             target.append(template(data));
        //         }
        //     };
        // };
        // if (current_page>last_request_page) {
        //     show_spinner();
        //     $.ajax({
        //         dataType: 'json',
        //         url:      Perch.path+'/core/apps/assets/async/get-assets.php?page='+current_page,
        //         data:     opts,
        //         success:  cb(callback),
        //         cache:    false
        //     });
        // }
    };

    var reloadTransactions = function()
    {
        current_page = 1;
        last_request_page = 0;
        getTransactions(current_opts, populate_chooser);

        $.ajax({
            dataType: 'json',
            url:      '/statements'+current_page,
            data:     opts,
            success:  cb(callback),
            cache:    false
        });
    };

    return {
        init: init
    };

}();

if (typeof(jQuery)!='undefined') {
    jQuery(function($) {
        BookKeeper.UI.ImportStatement.init();
    });
}