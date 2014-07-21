<table class="table  table-grid  editable-table  transaction-table  js-editable-table"  data-url="{{ URL::route('records.create') }}">
    <thead>
    <tr>
        <th colspan="2">Date</th>
        <th colspan="5">Payee</th>
        <th colspan="8">Description</th>
        <th colspan="2" class="align-right">Amount (£)</th>
        <th colspan="3" class="align-right">Category</th>
        <th colspan="2" class="align-right">Stream</th>
<!--        <th colspan="2">&nbsp;</th> --> <!-- utils -->
    </tr>
    </thead>
    <tbody>
    @if(count($records) > 0)
    @foreach($records as $record)
    <tr class="editable-row  js-editable-row">

        <td colspan="2">
            <span class="js-editable-value">{{ $record->date->format('d/m/Y') }}</span>
            <input type="text" name="date" class="form-control  datepicker" data-editable-input value="{{ $record->date->format('d/m/Y') }}">
        </td>

        <td colspan="5">
            <span class="js-editable-value">{{ $record->payee }}</span>
            <input type="text" name="payee" class="form-control" value="{{ $record->payee }}" data-editable-input>
        </td>

        <td colspan="8">
            <span class="js-editable-value">{{ $record->description }}</span>
            <input type="text" name="description" class="form-control" value="{{ $record->description }}" data-editable-input>
        </td>

        <td colspan="2" class="align-right  {{ $record->amountType }}">{{ $record->amount }}</td>

        <td colspan="3" class="align-right">
            <span class="js-editable-value">-</span>
            {{ Form::select('category', $categories, 1, ['class' => 'form-control', 'data-editable-input']) }}
        </td>

        <td colspan="2" class="align-right">
            <span class="js-editable-value">Music</span>
            {{ Form::select('stream', $streams, 1, ['class' => 'form-control', 'data-editable-input']) }}
        </td>

<!--        <td colspan="2" class="dropdown  transaction-utils" data-no-edit>-->
<!--            <a href="#" class="btn  btn--transaction  btn--transaction-ok"><i class="glyphicon-ok"></i></a>-->
<!--            <a class="dropdown-toggle  btn  btn--transaction" data-toggle="dropdown" href="#">-->
<!--                <i class="caret"></i>-->
<!--            </a>-->
<!--            <ul class="dropdown-menu  dropdown-menu-right" role="menu">-->
<!--                <li><a href="#" class="js-split-transaction">Split Transaction</a></li>-->
<!--                <li><a href="#">Another action</a></li>-->
<!--            </ul>-->
<!--        </td>-->
    </tr>
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