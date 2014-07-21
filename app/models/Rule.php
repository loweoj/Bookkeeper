<?php

class Rule extends \Eloquent {

	protected $fillable = ['title', 'conditionJson', 'conditionType', 'to_payee', 'to_category', 'to_stream', 'to_description', 'splitJson'];

    public $softDelete = true;


}