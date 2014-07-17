if (typeof(BookKeeper) == 'undefined') {
    BookKeeper      = {};
    BookKeeper.UI   = {};
}

BookKeeper.UI.EditableTable = function()
{
    var tableSelector = '.js-editable-table';
    var rowSelector = '.js-editable-row';
    var cellValueSelector = '.js-editable-value';

    var init    = function() {
        // $('.js-transaction-table').DataTable();
        EditableTable.init();
    };

    var EditableTable = {

        init: function()
        {
            // Bind cell editing to the transaction table
            $( tableSelector ).on('click', rowSelector + ' > td:not([data-no-edit])', EditableTable.startEditingRow);

            // Bind the date picker
            $( '.datepicker' ).datepicker({
                format: 'dd/mm/yyyy'
            });
        },

        startEditingRow: function()
        {
            $cell = $(this);
            $row = $cell.parent('tr');

            // Don't overwrite values if already editing!
            if( $row.hasClass('editing') ) return;

            // Set editing mode
            $row.addClass('editing');

            // We don't need to change the values of inputs.
            // They are populated by the server, and stay
            // updated as they are edited by the user.

            /*
            // Find cells
            $cells = $row.find('td');

            // Fill all the inputs with the current values.
            $cells.each(function(){
                cell = $(this);
                input = cell.find('[data-editable-input]');

                // If no input then get out.
                if( input.length == 0 ) return;

                // Find the value of the field
                currentValue = cell.find( cellValueSelector ).html();

                // Fill the input with the value.
                input.val(currentValue);
            });

            // Focus on the input clicked.
            $cell.find('[data-editable-input]').focus().select();
            */

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