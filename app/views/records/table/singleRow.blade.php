<tr class="editable-row  js-editable-row" id="{{ $record->id }}" data-url="{{ URL::route('records.update', $record->id) }}">
    <td colspan="2">
        <span class="js-editable-value">{{ $record->date->format('d/m/Y') }}</span>
        <input type="text" name="date" class="form-control  datepicker" data-editable-input
               value="{{ $record->date->format('d/m/Y') }}">
    </td>

    <td colspan="4">
        <span class="js-editable-value">{{ $record->payee }}</span>
        <input type="text" name="payee" class="form-control" value="{{ $record->payee }}" data-editable-input>
    </td>

    <td colspan="8">
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
        {{ Form::select('category', $categories, $record->category->id, ['class' => 'form-control', 'data-editable-input']) }}
    </td>

    <td colspan="2" class="align-right">
        <span class="js-editable-value">{{ $record->stream->name }}</span>
        {{ Form::select('stream', $streams, $record->stream->id, ['class' => 'form-control', 'data-editable-input']) }}
    </td>

    <td colspan="2" class="align-right  dropdown  util-btn-group" data-no-edit>
        @if($record->hasAttachment())
        <a href="#" data-toggle="modal" data-target="#editAttachmentModal" class="js-add-attachment  has-attachment  btn--attachment">
            <i class="glyphicon-paperclip"></i>
            <img class="attachment-thumb" src="/img/{{ $record->attachment->thumb }}" alt="{{ $record->attachment->name }}"/>
        </a>

        @else
        <a href="#" data-toggle="modal" data-target="#addAttachmentModal" class="js-add-attachment  btn--attachment"><i class="glyphicon-paperclip"></i></a>
        @endif

        <a class="dropdown-toggle  btn  btn--util" data-toggle="dropdown" href="#">
            <i class="caret"></i>
        </a>
        <ul class="dropdown-menu  dropdown-menu-right" role="menu">
            <li><a href="#" class="js-split-transaction">Split Transaction</a></li>
            <li><a href="#">Another action</a></li>
        </ul>
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
