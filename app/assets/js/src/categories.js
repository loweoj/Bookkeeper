if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.Categories = function()
{

    var currentDeleteCat;
    var $categoriesTable = $('.js-categories-table');

    var init = function()
    {
        // Load js modal template
        $categoriesTable.on('click', '.js-edit-category', editCategory);
        $categoriesTable.on('click', '.js-delete-category', deleteCategory);

        // Add clicked name onto form data
        $('body').on('click', 'input[type=submit]', function(){
           $(this).parents('form').data('clicked', this.name);
        });

        // Subscribe to ajax form result
        $.subscribe('ajax.modal.success.createCategory', postCreateCategory);
        $.subscribe('ajax.modal.success.editCategory', postEditCategory);
    };

    var postCreateCategory = function(e, $form, data)
    {
        // Hide modal if we need to
        if( $form.data('clicked') == 'create-one')
            $('.modal').modal('hide');

        // Cache the old CODE
        var newCode = $('input[data-next-code]').val();

        // Reset Form
        resetForm($form);

        // Clear any errors
        $('.has-error').each(function(i){
            $(this).find('help-block').remove();
        }).removeClass('has-error');

        // Increase next code
        ++newCode;
        $('input[data-next-code]').val(newCode);

        // Append the new row
        $tr = $(data);
        $categoriesTable.append($tr);
        $tr.effect("highlight", {}, 3000);
    };

    var postEditCategory = function(e, $form, data)
    {
        $('#editCategoryModal').modal('hide');

        // Reset Form
        resetForm($form);

        // Clear any errors
        $('.has-error').each(function(i){
            $(this).find('help-block').remove();
        }).removeClass('has-error');

        // Append the new row
        $tr = $(data);
        $categoriesTable.find('tr[data-id="' + $tr.data('id')+ '"]').replaceWith($tr);
        $tr.effect("highlight", {}, 3000);
    };

    var editCategory = function(e)
    {
        e.preventDefault();

        // the edit link
        $this = $(this);
        var categoryJson = $(this).parents('tr').data('json');

        var template = $('#editModalTemplate').html();
        var modalHtml = tmpl(template, {category: categoryJson});

        // Show the modal
        $modal = $(modalHtml).addClass('js-templatedModal');
        $('body').append($modal);
        $modal.modal({show:false});

        // Remove modal from DOM when hidden
        $modal.on('hidden.bs.modal',function(e) {
           $(this).remove();
        });
    };

    var deleteCategory = function(e)
    {
        e.preventDefault();
        $this = $(this);
        $modal = $('#deleteModal');
        json = $this.parents('tr').data('json');

        // Cache current category
        currentDeleteCat = json;
        $modal.find('[data-category-name]').html(json.name);
        $modal.on('submit', 'form', ajaxDelete);
    }

    var ajaxDelete = function(e)
    {
        e.preventDefault();

        cat = currentDeleteCat;
        $form = $(this);
        $modal = $('#deleteModal');

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action') + '/' + cat.id,
            data: {},
            success: function(data) {
                $('tr[data-id='+cat.id+']').remove();
                $modal.modal('hide');
                $modal.off('submit');
                currentDeleteCat = null;
            },
            error: function(xhr, textStatus, thrownError) {
                console.log('Ajax Error: ' + xhr.status + ': ' + thrownError);
            }
        });
    }

    var resetForm = function($form)
    {
        $form.find('input:text, input:password, input:file, select, textarea').val('');
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