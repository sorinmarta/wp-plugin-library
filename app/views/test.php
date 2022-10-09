<h1>Test</h1>

<?php

use WPPL\Lib\WPPL_Form;

$form = new WPPL_Form('wppl-test-form');
$form->label([
	'id' => 'test-text-label',
    'for' => 'test-text',
	'content' => 'Test Text',
	'group' => 'start'
]);
$form->single_text([
	'id' => 'test-text',
	'name' => 'test-text',
	'group' => 'end',
    'required' => 'true'
]);
$form->label([
	'id' => 'test-text-label2',
	'for' => 'test-text2',
	'content' => 'Test Text',
	'group' => 'start'
]);
$form->number([
	'id' => 'test-text2',
	'name' => 'test-text2',
	'group' => 'end',
	'required' => 'true'
]);
$form->label([
	'id' => 'test-text-label3',
	'for' => 'test-text3',
	'content' => 'Test Text',
	'group' => 'start'
]);
$form->email([
	'id' => 'test-text3',
	'name' => 'test-text3',
	'group' => 'end',
	'required' => 'true'
]);

$form->submit();
$form->render();
