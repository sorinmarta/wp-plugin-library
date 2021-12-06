<h1>WPPL Settings</h1>

<?php

new WPPL_Form('wppl-test-form', wp_create_nonce('wppl-test-form'), array(
    array(
        'element' => 'input',
        'type' => 'text',
        'name' => 'wppl-text-input',
        'id' => 'wppl-text-input'
    ),
    array(
        'element' => 'select',
        'options' => array(
            array(
                'name' => 'wppl-option-one',
                'id' => 'wppl-option-one',
                'value' => 'the first option'
            ),
            array(
                'name' => 'wppl-option-two',
                'id' => 'wppl-option-two',
                'value' => 'the second option'
            )
        ),
        'name' => 'wppl-select-input',
        'id' => 'wppl-select-input'
    ),
    array(
        'element' => 'label',
        'id' => 'wppl-label',
        'class' => 'wppl-label',
        'for' => 'wppl-checkbox-input',
        'label' => 'Tick this if you are awesome'
    ),
    array(
        'element' => 'input',
        'type' => 'checkbox',
        'name' => 'wppl-checkbox-input',
        'id' => 'wppl-checkbox-input'
    ),
    array(
        'element' => 'input',
        'type' => 'submit',
        'name' => 'wppl-submit',
        'id' => 'wppl-submit'
    )
));

?>