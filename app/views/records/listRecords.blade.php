@extends('layouts.master')

@section('content')
<div class="container">
    <h1>{{ $recordTypeTitle }}</h1>

    <div class="util-bar">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createRecordModal"><i class="glyphicon-plus"></i> Add Record</a>
        @include('records._createRecordForm')
    </div>

    @if( count($errors->all()) == 1 )
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <p><strong>Uh oh, something went wrong!</strong> {{ $errors->all()[0] }}</p>
    </div>
    @endif



    @include('records.table.recordTable')

    @if(count($records) == 0)
    <p>Sorry, there are currently no transactions to reconcile. Why not <a href="#" data-toggle="modal" data-target="#importStatementModal">import a statement</a></p>
    @endif
</div>

@include('records._addAttachmentForm')

@stop