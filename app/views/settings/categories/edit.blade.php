@extends('layouts.master')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li class="active">Data</li>
    </ol>
    <div class="row">
        <div class="col-md-6">
            <h1>Settings: Categories</h1>
            <h2>Editing {{ $category->code }} {{ $category->name }}</h2>
            {{ Form::model($category, ['url' => 'settings/categories', '', 'class' => 'form-horizontal  js-category-form']) }}
            <div class="form-group @if($errors->has('code')) has-error @endif">
                {{ Form::label('code', 'Code', ['class'=>'col-sm-2  control-label']) }}
                <div class="col-sm-10">{{ Form::text('code', null, ['class'=>'form-control']) }}</div>
                {{ $errors->first('code', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
            </div>
            <div class="form-group @if($errors->has('name')) has-error @endif">
                {{ Form::label('name', '', ['class'=>'col-sm-2  control-label']) }}
                <div class="col-sm-10">{{ Form::text('name', null, ['class'=>'form-control']) }}</div>
                {{ $errors->first('name', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
            </div>
            <div class="form-group @if($errors->has('description')) has-error @endif">
                {{ Form::label('description', 'Description', ['class'=>'col-sm-2  control-label']) }}
                <div class="col-sm-10">{{ Form::text('description', null, ['class'=>'form-control']) }}</div>
                {{ $errors->first('description', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
            </div>
            {{ Form::submit('Edit Category', ['class'=>'btn  btn-success']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop