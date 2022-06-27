<div style="margin-top:50px;">

<?php

$form = new \WPPL\Lib\WPPL_Form('test');
$form->label([
    'id' => 'test2',
    'for' => 'test',
    'label' => 'text field'
]);
$form->single_text([
        'id' => 'test',
        'name' => 'test'
]);

$form->submit();

$form->render();

?>

</div>
