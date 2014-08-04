if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.AjaxModals = function()
{
    var currentDeleteItem;
    var $modalTable = $('.js-modal-table');

    var init = function()
    {
        // Load js modal template
        $modalTable.on('click', '.js-modal-edit', showEditModal);
        // $('#editModal').on('show.bs.modal', showEditModal);

        $modalTable.on('click', '.js-modal-delete', showDeleteModal);

        // Add clicked name onto form data
        $('body').on('click', 'input[type=submit]', function(){
           $(this).parents('form').data('clicked', this.name);
        });

        // Subscribe to ajax form result
        $.subscribe('ajax.modal.success.createItem', postCreateModal);
        $.subscribe('ajax.modal.success.editItem', postEditModal);

    };

    /**
     * Show the edit form in modal
     * @param e
     */
    var showEditModal = function(e)
    {
        e.preventDefault();
        // the edit link
        $this = $(this);
        $modal = $('#editModal');
        var itemJson = $(this).parents('tr').data('json');
        var template = unescape($modal.html());
        var modalHtml = tmpl(template, {jsItem: itemJson});

        // Show the modal
        $modal = $modal.html(modalHtml).addClass('js-templatedModal');
//        $('body').append($modal);
        $modal.modal({show:false});

        // Remove modal from DOM when hidden
        $modal.on('hidden.bs.modal',function(e) {
           $(this).remove();
        });
    };

    /**
     * Callback once the create form has been submitted
     *
     * @param e
     * @param $form
     * @param data
     */
    var postCreateModal = function(e, $form, data)
    {
        // Hide modal if we need to
        if( $form.data('clicked') == 'create-one')
            $('.modal').modal('hide');

        // Publish pre-reset event to do any work
        $.publish('postCreateModal.preResetform', [$form, data]);

        // Reset Form
        resetForm($form);

        // Clear any errors
        $('.has-error').each(function(i){
            $(this).find('help-block').remove();
        }).removeClass('has-error');

        // Publish post-reset event to do any work
        $.publish('postCreateModal.postResetform', [$form, data]);

        // Prepend the new row
        $tr = $(data);
        $modalTable.prepend($tr);
        $tr.effect("highlight", {}, 3000);
    };

    /**
     * Callback once the edit form has been submitted
     *
     * @param e
     * @param $form
     * @param data
     */
    var postEditModal = function(e, $form, data)
    {
        $('.modal').modal('hide');

        // Reset Form
        resetForm($form);

        // Clear any errors
        $('.has-error').each(function(i){
            $(this).find('help-block').remove();
        }).removeClass('has-error');

        // Append the new row
        $tr = $(data);
        $modalTable.find('tr[data-id="' + $tr.data('id')+ '"]').replaceWith($tr);
        $tr.effect("highlight", {}, 3000);
    };

    /**
     * Show the delete modal
     *
     * @param e
     */
    var showDeleteModal = function(e)
    {
        e.preventDefault();
        $this = $(this);
        $modal = $('#deleteModal');
        json = $this.parents('tr').data('json');

        // Cache current category
        currentDeleteItem = json;

        $modal.find('[data-item-name]').html(json.name);
        $modal.on('submit', 'form', ajaxDelete);
    };

    /**
     * Delete form submission function
     * Posts the ID to the server to delete
     * @param e
     */
    var ajaxDelete = function(e)
    {
        e.preventDefault();

        item = currentDeleteItem;
        $form = $(this);
        $modal = $('#deleteModal');

        url = $form.attr('action') + '/' + item.id;
        console.log(url);

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action') + '/' + item.id,
            data: {},
            success: function(data) {
                $('tr[data-id='+item.id+']').remove();
                $modal.modal('hide');
                $modal.off('submit');
                currentDeleteItem = null;
                $.publish('deleteModal.success', [$form]);
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
        BookKeeper.UI.AjaxModals.init();
    });
}

/*

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

 */