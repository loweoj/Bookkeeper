@extends('master')

@section('content')
<div class="container">
    <h1>Transactions</h1>
    <table class="table  table-grid  transaction-table  js-transaction-table">
        <thead>
            <tr>
                <th colspan="2">Date</th>
                <th colspan="6">Payee</th>
                <th colspan="8">Description</th>
                <th colspan="2">Amount</th>
                <th colspan="3">Category</th>
                <th colspan="2">Stream</th>
                <th colspan="1">&nbsp;</th> <!-- utils -->
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr class="transaction-row  js-transaction-row">
                <td colspan="2">{{ $transaction['date']->format('d/m/Y') }}</td>
                <td colspan="6" class="transaction-payee">
                    <span class="js-transaction-value">{{ $transaction['name'] }}</span><input type="text" name="inplace_value" class="form-control  inplace_field  js-inplace_field">
                </td>
                <td colspan="8" class="transaction-desc">
                    <span class="js-transaction-value">{{ $transaction['description'] }}</span><input type="text" name="inplace_value" class="form-control  inplace_field  js-inplace_field">
                </td>
                <td colspan="2" class="{{ $transaction['type'] }}">£{{ $transaction['amount'] }}</td>
                <td colspan="3" >Category</td>
                <td colspan="2">Stream</td>
                <td colspan="1" class="dropdown" data-no-edit>
                    <a class="dropdown-toggle  select-arrow" data-toggle="dropdown" href="#">
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                        <li><a href="#" class="js-split-transaction">Split Transaction</a></li>
                        <li><a href="#">Another action</a></li>
                    </ul>
                </td>
            </tr>
        @endforeach
<!--             <tr class="js-transaction-row">
                <td>14/16/2014</td>
                <td><span class="js-transaction-value">BBC Symphony Orchestra</span><input type="text" name="inplace_value" class="form-control  inplace_field  js-inplace_field" maxlength="null"></td>
                <td>Some Concert</td>
                <td class="credit">£500</td>
                <td>Category</td>
                <td class="dropdown">
                    <a class="dropdown-toggle  select-arrow" data-toggle="dropdown" href="#">
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                        <li><a href="#" class="js-split-transaction">Split Transaction</a></li>
                        <li><a href="#">Another action</a></li>
                    </ul>
                </td>
            </tr> -->

<!--             <tr class="split-transaction-row  js-hidden">
                <td colspan="6" class="well">
                    <p>This row is hidden for good purposes.</p>
                    <p><button type="button" class="btn btn-success"><i class="glyphicon-ok"></i> Split Transaction</button> or <a href="#">close</a></p>
                </td>
            </tr> -->
        </tbody>
    </table>
</div>

@stop