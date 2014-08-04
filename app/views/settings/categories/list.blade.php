@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Settings: Categories</h1>

    <div class="util-bar">
        <div class="align-right">
            <a class="dropdown-toggle  btn  btn-primary" data-toggle="modal" data-target="#createCategoryModal" href="#">Add New</a>
        </div>

        <div class="modal  fade  js-ajax-modal" id="createCategoryModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{ Form::open(['route' => 'categories.create', 'class' => 'form-horizontal  js-ajax-form-createCategory']) }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Create New Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group @if($errors->has('type')) has-error @endif">
                                {{ Form::label('type', 'Type', ['class'=>'col-sm-2  control-label']) }}
                                <div class="col-sm-5">{{ Form::select('type', ['income' => 'Income', 'expense' => 'Expense'], 'Income', ['class' => 'form-control']) }}</div>
                                {{ $errors->first('type', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                            </div>

                            <div class="form-group @if($errors->has('code')) has-error @endif">
                                {{ Form::label('code', 'Code', ['class'=>'col-sm-2  control-label']) }}
                                <div class="col-sm-10">{{ Form::text('code', $nextCode, ['class'=>'form-control', 'data-next-code']) }}</div>
                                {{ $errors->first('code', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                            </div>
                            <div class="form-group @if($errors->has('name')) has-error @endif">
                                {{ Form::label('name', 'Name', ['class'=>'col-sm-2  control-label']) }}
                                <div class="col-sm-10">{{ Form::text('name', null, ['class'=>'form-control']) }}</div>
                                {{ $errors->first('name', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                            </div>
                            <div class="form-group @if($errors->has('description')) has-error @endif">
                                {{ Form::label('description', 'Description', ['class'=>'col-sm-2  control-label']) }}
                                <div class="col-sm-10">{{ Form::textarea('description', null, ['class'=>'form-control', "rows"=>4]) }}</div>
                                {{ $errors->first('description', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::hidden('editId', '') }}
                        {{ Form::input('submit', 'create-one', 'Create Category', ['class'=>'btn  btn-primary']) }}
                        {{ Form::input('submit', 'create-many', 'Create and Add Another', ['class'=>'btn  btn-primary']) }}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    @if( Session::has('success') )
        <div class="alert alert-success flash" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>Success!</strong> Created category successfully.
        </div>
    @endif

    <table class="table  table-grid  js-modal-table">
        <thead>
        <tr>
            <th colspan="2">Code</th>
            <th colspan="5">Name</th>
            <th colspan="12">Description</th>
            <th colspan="2" class="align-right">Type</th>
            <th colspan="3">&nbsp;</th> <!-- utils -->
        </tr>
        </thead>
        <tbody>
        @if(count($categories) > 0)
        @foreach($categories as $category)

            @include('settings.categories.singleRow', array('category' => $category, 'this' => 'that'))

        @endforeach
        @endif
        </tbody>
    </table>
</div>

{{-- Include Delete Form --}}
<div class="modal fade hiden" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>"<span data-item-name></span>"</strong>?</p>
            </div>
            <div class="modal-footer">
                {{ Form::open(['route' => ['categories.delete', '']]) }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                {{ Form::submit('Delete', ['class'=>'btn btn-danger danger']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>


{{-- Include Edit Form --}}
{{-- Only render script tag if page is not ajax response. --}}
{{-- <script type="text/js-template" id="editModalTemplate"> --}}
    <div class="modal fade  js-ajax-modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Edit Category">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::rawOpen(['route' => ['categories.update', 'rawOpenPlaceholder'], 'method'=>'post', 'class' => 'form-horizontal  js-ajax-form-editItem'], '<%= jsItem.id %>') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit <%= jsItem.name %></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group @if($errors->has('type')) has-error @endif">
                            {{ Form::label('type', 'Type', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-5">{{ Form::rawSelect('type', ['income' => 'Income', 'expense' => 'Expense'], '<%= jsItem.type %>', ['class' => 'form-control']) }}</div>
                            {{ $errors->first('type', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>

                        <div class="form-group @if($errors->has('code')) has-error @endif">
                            {{ Form::label('code', 'Code', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-10">{{ Form::rawInput('text', 'code', '<%= jsItem.code %>', ['class'=>'form-control', 'data-next-code']) }}</div>
                            {{ $errors->first('code', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            {{ Form::label('name', 'Name', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-10">{{ Form::rawInput('text', 'name', '<%= jsItem.name %>', ['class'=>'form-control']) }}</div>
                            {{ $errors->first('name', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>
                        <div class="form-group @if($errors->has('description')) has-error @endif">
                            {{ Form::label('description', 'Description', ['class'=>'col-sm-2  control-label']) }}
                            <div class="col-sm-10">{{ Form::rawInput('textarea', 'description', '<%= jsItem.description %>', ['class'=>'form-control', "rows"=>4]) }}</div>
                            {{ $errors->first('description', '<span class="help-block  col-sm-offset-2  col-sm-10">:message</span>') }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::submit('Edit Category', ['class'=>'btn  btn-success']) }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
{{-- </script> --}}
@stop