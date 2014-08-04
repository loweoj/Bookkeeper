if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.Categories = function()
{
    var init = function()
    {
        // Category Form Subscribers for handling category code
        var catCode = 0;
        $.subscribe('postCreateModal.preResetform', function(e, $form, data){
            // Cache the old CODE
            catCode = $('input[data-next-code]').val();
        });

        $.subscribe('postCreateModal.postResetform', function(e, $form, data){
            // Increase next code
            ++catCode;
            $('input[data-next-code]').val(catCode);
        });

        $.subscribe('deleteModal.success', function(e, $form){
            $('input[data-next-code]').val('');
        });
    };

    return {
        init: init
    };

}();

if (typeof(jQuery)!='undefined') {
    jQuery(function($) {
        BookKeeper.UI.Categories.init();
    });
}