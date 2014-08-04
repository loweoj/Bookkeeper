<tr class="editable-row  js-editable-row" data-url="{{ URL::route('records.update', $record->id) }}">

    <td colspan="2">
        <span class="js-editable-value">{{ $record->date->format('d/m/Y') }}</span>
        <input type="text" name="date" class="form-control  datepicker" data-editable-input
               value="{{ $record->date->format('d/m/Y') }}">
    </td>

    <td colspan="5">
        <span class="js-editable-value">{{ $record->payee }}</span>
        <input type="text" name="payee" class="form-control" value="{{ $record->payee }}" data-editable-input>
    </td>

    <td colspan="7">
        <span class="js-editable-value">{{ $record->description }}</span>
        <input type="text" name="description" class="form-control" value="{{ $record->description }}"
               data-editable-input>
    </td>

    <td colspan="2" class="align-right  {{ $record->amountType }}">
        <span class="js-editable-value">{{ number_format($record->amount, 2) }}</span>
        <input type="text" name="amount" class="form-control" value="{{ $record->amount }}"
               data-editable-input>
    </td>

    <td colspan="4" class="align-right">
        <span class="js-editable-value">{{ $record->category->name }}</span>
        {{ Form::select('category', $categories, 1, ['class' => 'form-control', 'data-editable-input']) }}
    </td>

    <td colspan="2" class="align-right">
        <span class="js-editable-value">{{ $record->stream->name }}</span>
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
