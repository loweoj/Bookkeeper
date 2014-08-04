if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.EditableTable = function()
{
    var tableSelector = '.js-editable-table';
    var rowSelector = '.js-editable-row';
    var cellValueSelector = '.js-editable-value';
    var $editableTable = $(tableSelector);

    var init    = function() {
        // $('.js-transaction-table').DataTable();
        EditableTable.init();
    };

    var EditableTable = {

        init: function()
        {
            // Bind cell editing to the transaction table
            $editableTable.on('click', rowSelector + ' > td:not([data-no-edit])', EditableTable.startEditingRow);
        },

        startEditingRow: function()
        {
            $cell = $(this);
            $row = $cell.parent('tr');

            // Don't overwrite values if already editing!
            if( $row.hasClass('editing') ) return;

            // Set editing mode
            $row.addClass('editing');

            // Cache current attributes
            $row.data('lastAttributes', EditableTable._buildRowData($row));

            // Focus on the input clicked.
            $cell.find('[data-editable-input]').focus().select();

            // Start listening for an outside click.
            $(document).on('mouseup.stopEditingTable', EditableTable.checkShouldEndEditing);
        },

        stopEditingRow: function()
        {
            $row = $( rowSelector + '.editing');

            $cells = $row.find('td');

            $cells.each(function(){
                cell = $(this);
                input = cell.find('[data-editable-input]');

                // If no input then get out.
                if( input.length == 0 ) return;

                // Find the value of the field
                currentValue = EditableTable._getTagText(input);

                // Fill the cell with the current value.
                cell.find( cellValueSelector ).html(currentValue);
            });

            // Hide all inputs etc.
            $row.removeClass('editing');

            // Save Row.
            EditableTable.saveRow($row);

            // Stop listening for outside click
            $(document).off('mouseup.stopEditingTable');
        },

        checkShouldEndEditing: function(e)
        {
            // Table row currently being edited
            var row = $( rowSelector + '.editing' );
            if (!row.is(e.target) // if the target of the click isn't the row...
                && row.has(e.target).length === 0 // ... nor a descendant of the row
                && $(e.target).parents('.datepicker').length == 0) // and is not part of a datepicker
            {
                EditableTable.stopEditingRow();
            }
        },

        saveRow: function($row)
        {
            newData = EditableTable._buildRowData($row);
            oldData = $row.data('lastAttributes');

            // If the data is the same, we don't need to save!
            if(_.isEqual(newData, oldData)) return;

            url = $row.data('url');

            // Do Ajax
            $.ajax({
                type: 'post',
                url: url,
                data: newData,
                success: function(data) {
                    console.log(data);
                    if (data.success)
                    {
                        $.publish('editableTable.success', [$form, data.payload]);
                    } else {
                        $data = $(data);
                        // Fill the form with ajax content
                        $form.html( $data.find(namespacedFormSelector).html() );
                        $.publish('ajax.modal.error.'+namespace, [$form, data.payload]);
                    }
                },
                error: function(xhr, textStatus, thrownError) {
                    console.log('Ajax Error: ' + xhr.status + ': ' + thrownError);
                }
            });
        },

        _buildRowData: function($row)
        {
            data = {};
            $row.find('input,select').each(function(){
                data[this.name] = $(this).val();
            });
            return data;
        },

        _getTagText: function( $input )
        {
            var tagName = $input.prop('tagName');
            if( tagName == 'INPUT' ) return $input.val();
            if( tagName == 'SELECT' ) return $input.find(":selected").text();
            return false;
        }
    };

    return {
        init: init
    };

}();

if (typeof(jQuery)!='undefined') {
    jQuery(function($) {
        BookKeeper.UI.EditableTable.init();
    });
}