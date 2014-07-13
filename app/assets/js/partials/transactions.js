if (typeof(Books) == 'undefined') {
    Books      = {};
    Books.UI   = {};
}

Books.UI.Transactions = function()
{
    var tableSelector = '.js-transaction-table';
    var rowSelector = '.js-transaction-row';
    var cellValueSelector = '.js-transaction-value';

    var init    = function() {
        // $('.js-transaction-table').DataTable();
        EditTransactions.init();
    };

    var EditTransactions = {

        init: function()
        {
            // Bind cell editing to the transaction table
            $( tableSelector ).on('click', rowSelector + ' > td:not([data-no-edit])', EditTransactions.startEditingRow);
        },

        startEditingRow: function()
        {
            $cell = $(this);
            $row = $(this).parent('tr');
            $row.addClass('editing');

            $cells = $row.find('td');

            // Fill all the inputs with the current values.
            $cells.each(function(){
                cell = $(this);
                input = cell.find('input');

                // If no input then get out.
                if( input.length == 0 ) return;

                // Find the value of the field
                currentValue = cell.find( cellValueSelector ).html();

                // Fill the input with the value.
                input.val(currentValue);
            });

            // Focus on the input clicked.
            $cell.find('input').focus().select();

            // Start listening for an outside click.
            $(document).on('mouseup.endEditingTransaction', EditTransactions.checkShouldEndEditing);
        },

        stopEditingRow: function()
        {
            $row = $( rowSelector + '.editing');

            $cells = $row.find('td');

            $cells.each(function(){
                cell = $(this);
                input = cell.find('input');

                // If no input then get out.
                if( input.length == 0 ) return;

                // Find the value of the field
                currentValue = input.val();

                // Fill the cell with the current value.
                cell.find( cellValueSelector ).html(currentValue);
            });

            // Hide all inputs etc.
            $row.removeClass('editing');

            // Stop listening for outside click
            $(document).off('mouseup.endEditingTransaction');
        },

        checkShouldEndEditing: function(e)
        {
            // Table row currently being edited
            var row = $( rowSelector + '.editing' );

            if (!row.is(e.target) // if the target of the click isn't the row...
                && row.has(e.target).length === 0) // ... nor a descendant of the row
            {
                EditTransactions.stopEditingRow();
            }
        },
    };

    return {
        init: init
    };

}();

if (typeof(jQuery)!='undefined') {
    jQuery(function($) {
        Books.UI.Transactions.init();
    });
}