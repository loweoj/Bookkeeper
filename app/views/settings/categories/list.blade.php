@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Settings: Categories</h1>

    <div class="util-bar">
        <div class="align-right">
            <a class="dropdown-toggle  btn  btn-primary" data-toggle="modal" data-target="#createNewCategory" href="#">Add New</a>
        </div>

        <div class="modal fade" id="createNewCategory" tabindex="-1" role="dialog" aria-labelledby="Import Statement">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{ Form::open(['url' => 'settings/categories', 'class' => 'form-horizontal  js-ajax-form  js-category-form']) }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Create New Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group @if($errors->has('type')) has-error @endif">
                            {{ Form::label('type', 'Type', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-5">{{ Form::select('type', ['income' => 'Income', 'expense' => 'Expense'], 'Income', ['class' => 'form-control']) }}</div>
                            {{ $errors->first('type', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>

                        <div class="form-group @if($errors->has('code')) has-error @endif">
                            {{ Form::label('code', 'Code', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-10">{{ Form::text('code', $nextCode, ['class'=>'form-control']) }}</div>
                            {{ $errors->first('code', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            {{ Form::label('name', 'Name', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-10">{{ Form::text('name', '', ['class'=>'form-control']) }}</div>
                            {{ $errors->first('name', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>
                        <div class="form-group @if($errors->has('description')) has-error @endif">
                            {{ Form::label('description', 'Description', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-10">{{ Form::text('description', '', ['class'=>'form-control']) }}</div>
                            {{ $errors->first('description', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::submit('Add Category', ['class'=>'btn  btn-success']) }}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    {{ Form::close() }}
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

    @if( Session::has('success') )
        <div class="alert alert-success flash" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>Success!</strong> Created category successfully.
        </div>
    @endif

    <table class="table  table-grid  js-categories-table">
        <thead>
        <tr>
            <th colspan="4">Code</th>
            <th colspan="6">Name</th>
            <th colspan="6">Description</th>
            <th colspan="2">Type</th>
            <th colspan="4">&nbsp;</th> <!-- utils -->
        </tr>
        </thead>
        <tbody>
        @if(count($categories) > 0)
        @foreach($categories as $category)
        <tr>

            <td colspan="4">
                {{ $category->code }}
            </td>

            <td colspan="6">
                {{ $category->name }}
            </td>

            <td colspan="6">
                {{ $category->description }}
            </td>

            <td colspan="2">
                {{ $category->type }}
            </td>

            <td colspan="4" class="transaction-utils">
                <a href="{{ URL::action('CategoriesController@edit', ['id' => $category->id]) }}" class="btn  btn--transaction">Edit</a>
                <a href="#" class="btn  btn--transaction  js-delete"><i class="glyphicon-remove"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>


<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="Edit Category">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['url' => 'settings/categories', 'class' => 'form-horizontal  js-category-form']) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Edit <%category.name%></h4>
            </div>
            <div class="modal-body">
                <div class="form-group @if($errors->has('code')) has-error @endif">
                    {{ Form::label('code', 'Code', ['class'=>'col-sm-2  control-label']) }}
                    <div class="col-sm-10">{{ Form::text('code', '<%category.code%>', ['class'=>'form-control']) }}</div>
                    {{ $errors->first('code', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                </div>
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    {{ Form::label('name', 'Name', ['class'=>'col-sm-2  control-label']) }}
                    <div class="col-sm-10">{{ Form::text('name', '<%category.name%>', ['class'=>'form-control']) }}</div>
                    {{ $errors->first('name', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                </div>
                <div class="form-group @if($errors->has('description')) has-error @endif">
                    {{ Form::label('description', 'Description', ['class'=>'col-sm-2  control-label']) }}
                    <div class="col-sm-10">{{ Form::text('description', '<%category.description%>', ['class'=>'form-control']) }}</div>
                    {{ $errors->first('description', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::submit('Edit Category', ['class'=>'btn  btn-success']) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop