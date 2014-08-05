<table class="table  table-grid  editable-table  transaction-table  js-editable-table  js-modal-table">
    <thead>
    <tr>
        <th colspan="2">Date</th>
        <th colspan="4">Payee</th>
        <th colspan="6">Description</th>
        <th colspan="2" class="align-right">Amount (£)</th>
        <th colspan="4" class="align-right">Category</th>
        <th colspan="2" class="align-right">Stream</th>
        <th colspan="2" class="align-right">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @if(count($records) > 0)
    @foreach($records as $record)
        @include('records.table.singleRow', array('record' => $record))
    @endforeach
    @endif

    <!--             <tr class="split-transaction-row  js-hidden">
                    <td colspan="6" class="well">
                        <p>This row is hidden for good purposes.</p>
                        <p><button type="button" class="btn btn-success"><i class="glyphicon-ok"></i> Split Transaction</button> or <a href="#">close</a></p>
                    </td>
                </tr> -->
    </tbody>
</table>