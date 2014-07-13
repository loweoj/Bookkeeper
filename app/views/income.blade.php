@extends('master')

@section('content')
<div class="container">
    <h1>Transactions</h1>
    <table class="table table-hover js-transaction-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Payee</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Category</th>
                <th>&nbsp;</th> <!-- utils -->
            </tr>
        </thead>
        <tbody>
            <tr class="js-transaction-row">
                <td>14/16/2014</td>
                <td>BBC Symphony Orchestra</td>
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
            </tr>
<!--             <tr class="split-transaction-row  js-hidden">
                <td colspan="6" class="well">
                    <p>This row is hidden for good purposes.</p>
                    <p><button type="button" class="btn btn-success"><i class="glyphicon-ok"></i> Split Transaction</button> or <a href="#">close</a></p>
                </td>
            </tr> -->
            <tr>
                <td>15/06/2014</td>
                <td>O2</td>
                <td>Mobile Bill</td>
                <td class="debit">£28</td>
                <td>Category</td>
                <td class="dropdown">
                    <a class="dropdown-toggle  select-arrow" data-toggle="dropdown" href="#">
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                        <li><a href="#">Split Transaction</a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>01/03/2014</td>
                <td>SPOTIFY</td>
                <td>Inspiration and the like</td>
                <td class="credit">£200</td>
                <td>Category</td>
                <td class="dropdown">
                    <a class="dropdown-toggle  select-arrow" data-toggle="dropdown" href="#">
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                        <li><a href="#">Split Transaction</a></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@stop