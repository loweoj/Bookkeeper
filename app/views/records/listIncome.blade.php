@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Income</h1>

    <div class="util-bar">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createRecordModal"><i class="glyphicon-plus"></i> Add Record</a>
        @include('records._createRecordForm')
    </div>

    @include('records.recordTable')

    @if(count($records) == 0)
    <p>Sorry, there are currently no transactions to reconcile. Why not <a href="#" data-toggle="modal" data-target="#importStatementModal">import a statement</a></p>
    @endif
</div>

@stop