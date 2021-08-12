<h1>hi</h1>
<?php

new WPPL_Form('sorin_test', 'sorin_test', array( // The inputs array
    array( // The input
        'element' => 'input',
        'type' => 'text',
        'id' => 'test',
        'label' => 'Test',
        'name' => 'test'
    ),
    array( // The input
        'element' => 'input',
        'type' => 'text',
        'id' => 'test',
        'label' => 'Test',
        'name' => 'test'
    ),
    array( // The select
        'element' => 'select',
        'name' => 'test',
        'id' => 'test',
        'label' => 'Test',
        'options' => array(
            array(
                'value' => 'Sorin',
                'id' => 'test',
                'text' => 'test'
            ),
            array(
                'value' => 'Sorin',
                'id' => 'test',
                'text' => 'test'
            )
        ),
    ),
    array(
        'element' => 'input',
        'type' => 'submit',
        'id' => 'submit',
        'name' => 'submit'
    )
 ));