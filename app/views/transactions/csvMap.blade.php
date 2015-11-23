@extends('layouts.master')

@section('content')
    <div class="col-sm-6  col-container">
    <h1>CSV File Settings</h1>
        {{ Form::open(['route' => 'import.csv', 'class' => 'form-horizontal']) }}
            <h4>a) Select a preset mapping</h4>
            <div class="form-group  mb @if($errors->has('presetMapping')) has-error @endif">
                {{ Form::label('presetMapping', '', ['class'=>'col-sm-3  control-label']) }}
                <div class="col-sm-5">{{ Form::select('presetMapping', $presetMappings, null, ['class' => 'form-control']) }}</div>
                {{ $errors->first('presetMapping', '<span class="help-block  col-sm-offset-3  col-sm-9">:message</span>') }}
            </div>

            <h4>b) Set Mapping Details </h4>
            <div class="form-group  mb @if($errors->has('date')) has-error @endif">
                {{ Form::label('mappingName', 'Mapping Name', ['class'=>'col-sm-3  control-label']) }}
                <div class="col-sm-9">{{ Form::text('mappingName', '', ['class'=>'form-control']) }}</div>
                {{ $errors->first('date', '<span class="help-block  col-sm-offset-3  col-sm-9">:message</span>') }}
            </div>

            <h4>c) Match a column to a field</h4>

            <div class="faux-table-header  cf">
                <h5 class="col-sm-4">CSV Header field</h5>
                <h5 class="col-sm-8">Match to the following attribute in Bookkeeper</h5>
            </div>

            @foreach($csvCols as $col)
            <div class="form-group">
                {{ Form::label($col['title'], $col['title'], ['class'=>'col-sm-4  control-label']) }}
                <div class="col-sm-8">{{ Form::select($col['title'], $dbFields, null, ['class' => 'form-control']) }}</div>
                {{ $errors->first($col['id'], '<span class="help-block  col-sm-offset-4  col-sm-8">:message</span>') }}
            </div>
            @endforeach

        {{ Form::hidden('editId', '') }}
        {{ Form::input('submit', 'addTransactions', 'Add Transactions', ['class'=>'btn  btn-primary']) }}
    {{ Form::close() }}
    </div>


{{--<div class="modal  in  fade  js-ajax-modal" id="csvMapModal" tabindex="-1" role="dialog" style="display:block">--}}
    {{--<div class="modal-dialog">--}}
        {{--<div class="modal-content">--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
@stop