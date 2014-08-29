@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Transactions</h1>

    @if( count($errors->all()) )
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if( isset($status) && $status == 'success' )
    <div class="alert alert-success">
        <p>Success!</p>
    </div>
    @endif


    <div class="util-bar">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#importStatementModal"><i class="glyphicon-upload"></i> Import Statement</a>
        <div class="modal fade" id="importStatementModal" tabindex="-1" role="dialog" aria-labelledby="Import Statement">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Import Statements</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/import/" enctype="multipart/form-data" method="post" class="statement-dropzone" id="statementImportDrop">
                            <div class="fallback">
                                <input name="file" type="file" />
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

    <table class="table  table-grid  editable-table  transaction-table  js-editable-table">
        <thead>
            <tr>
                <th colspan="3">Date</th>
                <th colspan="6">Payee</th>
                <th colspan="6">Description</th>
                <th colspan="2" class="align-right">Amount (£)</th>
                <th colspan="3" class="align-right">Category</th>
                <th colspan="2" class="align-right">Stream</th>
                <th colspan="2">&nbsp;</th> <!-- utils -->
            </tr>
        </thead>
        <tbody>
        @if(count($transactions) > 0)
            @foreach($transactions as $transaction)
                <tr class="editable-row  js-editable-row">

                    <td colspan="3">
                        <span class="js-editable-value">{{ $transaction->date->format('d/m/Y') }}</span>
                        <input type="text" name="date" class="form-control  datepicker" data-editable-input value="{{ $transaction->date->format('d/m/Y') }}">
                    </td>

                    <td colspan="6" class="transaction-payee">
                        <span class="js-editable-value">{{ $transaction->payee }}</span>
                        <input type="text" name="payee" class="form-control" value="{{ $transaction->payee }}" data-editable-input>
                    </td>

                    <td colspan="6" class="transaction-desc">
                        <span class="js-editable-value">{{ $transaction->description }}</span>
                        <input type="text" name="description" class="form-control" value="{{ $transaction->description }}" data-editable-input>
                    </td>

                    <td colspan="2" class="align-right  {{ $transaction->amountType }}">{{ $transaction->amount }}</td>

                    <td colspan="3" class="align-right">
                        <span class="js-editable-value">-</span>
                        {{ Form::select('category', $categories, 1, ['class' => 'form-control', 'data-editable-input']) }}
                    </td>

                    <td colspan="2" class="align-right">
                        <span class="js-editable-value">Music</span>
                        <select name="category" class="form-control" data-editable-input>
                            <option value="1" selected>Music</option>
                            <option value="2">Web</option>
                            <option value="3">Music/Web</option>
                        </select>
                    </td>

                    <td colspan="2" class="dropdown  util-btn-group" data-no-edit>
                        <a href="#" class="btn  btn--util  btn--util-icon"><i class="glyphicon-ok"></i></a>
                        <a class="dropdown-toggle  btn  btn--util" data-toggle="dropdown" href="#">
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                            <li><a href="#" class="js-split-transaction">Split Transaction</a></li>
                            <li><a href="#">Another action</a></li>
                        </ul>
                    </td>
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
    @if(count($transactions) == 0)
    <p>Sorry, there are currently no transactions to reconcile. Why not <a href="#" data-toggle="modal" data-target="#importStatementModal">import a statement</a></p>
    @endif
</div>

@stop