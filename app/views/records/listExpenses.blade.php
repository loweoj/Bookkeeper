@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Expenses</h1>

    <div class="util-bar">
        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importStatementModal"><i class="glyphicon-upload"></i> Import Statement</a>
    </div>

    @include('records.table.recordTable')

    @if(count($records) == 0)
    <p>Sorry, there are currently no transactions to reconcile. Why not <a href="#" data-toggle="modal" data-target="#importStatementModal">import a statement</a></p>
    @endif
</div>

@stop