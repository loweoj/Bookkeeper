<?php

Form::macro('rawInput', function($type, $name, $value = null, $options = array())
{
    $input = Form::input($type, $name, '%s', $options);
    return sprintf($input, $value);
});

Form::macro('rawSelect', function($name, $list = array(), $selected = null, $options = array())
{
    $select = Form::select($name, $list, '%s', $options);
    return sprintf($select, $selected);
});

Form::macro('rawOpen', function($opts, $value)
{
    $formOpen = Form::open($opts);
    return str_replace('rawOpenPlaceholder', $value, $formOpen);
});