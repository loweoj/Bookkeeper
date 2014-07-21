<div class="modal  fade  js-ajax-modal" id="createRecordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['route' => 'categories.create', 'class' => 'form-horizontal  js-ajax-form-createRecord']) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Create New Record</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        {{ Form::label('type', 'Type', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-5">{{ Form::select('type', ['income' => 'Income', 'expense' => 'Expense'], $type, ['class' => 'form-control']) }}</div>
                        {{ $errors->first('type', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
                    </div>
                    <div class="form-group @if($errors->has('date')) has-error @endif">
                        {{ Form::label('date', 'Date', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-9">{{ Form::text('date', date('d/m/Y', time()), ['class'=>'form-control  datepicker', 'data-next-code']) }}</div>
                        {{ $errors->first('date', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
                    </div>
                    <div class="form-group @if($errors->has('payee')) has-error @endif">
                        {{ Form::label('payee', 'Payee', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-9">{{ Form::text('payee', null, ['class'=>'form-control']) }}</div>
                        {{ $errors->first('payee', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
                    </div>
                    <div class="form-group @if($errors->has('description')) has-error @endif">
                        {{ Form::label('description', 'Description', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-9">{{ Form::text('description', null, ['class'=>'form-control']) }}</div>
                        {{ $errors->first('description', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
                    </div>
                    <div class="form-group @if($errors->has('amount')) has-error @endif">
                        {{ Form::label('amount', 'Amount', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">£</span>
                                {{ Form::text('amount', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        {{ $errors->first('amount', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
                    </div>
                    <div class="form-group @if($errors->has('category')) has-error @endif" data-category-income>
                        {{ Form::label('category', 'Category', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-5">{{ Form::select('category', $categories, 1, ['class' => 'form-control', 'data-editable-input']) }}</div>
                        {{ $errors->first('category', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
                    </div>
                    <div class="form-group @if($errors->has('stream')) has-error @endif" data-category-income>
                        {{ Form::label('stream', 'Stream', ['class'=>'col-sm-3  control-label']) }}
                        <div class="col-sm-5">{{ Form::select('stream', $streams, 1, ['class' => 'form-control', 'data-editable-input']) }}</div>
                        {{ $errors->first('stream', '<span class="help-block  col-sm-offset-2  col-sm-9">:message</span>') }}
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


 