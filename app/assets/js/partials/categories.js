if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.Categories = function()
{
    var $categoriesTable = $('.js-categories-table');
    var formClass = '.js-ajax-form';

    var init = function()
    {
        initEditCategories();
        initAjax();
    };

    var initAjax = function()
    {
        $(formClass).on('submit', submitAjax);
    };

    var submitAjax = function(e)
    {
        e.preventDefault();

        var $form = $(this);
        $.ajax({
            type: 'post',
            url: $form.action,
            data: $form.serialize(),
            success: function(data) {
                if (data.success)
                {
                    // Tidy Up
                    $('.modal').modal('hide');
                    $form[0].reset();
                    // Append the new row
                    $tr = $(data.payload);
                    $categoriesTable.append($tr);
                    $tr.effect("highlight", {}, 3000);
                } else {
                    $data = $(data);
                    $form.html( $data.find(formClass).html() );
                }
            },
            error: function(xhr, textStatus, thrownError) {
                console.log('Ajax Error: ' + xhr.status + ': ' + thrownError);
            }
        });
    };

    var initEditCategories = function()
    {
        $('.js-edit-category').on('click', function() {
            _populateEditForm()
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