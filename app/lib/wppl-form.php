<?php

namespace WPPL\Lib;

class WPPL_Form{
    private string $action;
    private string $nonce;
    private array $inputs = [];
    private string $id;

    /**
     * The constructor that generates the form
     *
     * @param string $action - The action element of the form
     * @param string $nonce - The nonce hidden input
     * @param array $inputs - The array of inputs
     */

    public function __construct(string $action, mixed $nonce = false, mixed $id = false)
    {
        $this->action = $action;

        if($nonce){
            $this->nonce = wp_create_nonce($nonce);
        }else{
            $this->nonce = wp_create_nonce($action);
        }

        if(!$id){
            $this->id = uniqid('form-');
        }
    }

    public function single_text(array $arguments): void
    {
        $this->add_element($arguments, 'input', 'text');
    }

    public function email(array $arguments): void
    {
        $this->add_element($arguments, 'input', 'email');
    }

    public function number(array $arguments): void
    {
        $this->add_element($arguments, 'input', 'number');
    }

    public function textarea(array $arguments): void
    {
        $this->add_element($arguments, 'textarea');
    }

    public function select(array $arguments): void
    {
        $this->add_element($arguments, 'select');
    }

    public function option(array $arguments, string $select_id): void
    {
        if(!isset($this->inputs[$select_id])){
            wppl_dd("The select element doesn't exist");
        }

        if(!is_array($this->inputs[$select_id])){
            $this->inputs[$select_id] = array();
        }

        array_push($this->inputs[$select_id], [
                'element' => 'option',
                'id'            => $arguments['id'],
                'name'          => $arguments['name'],
                'placeholder'   => $arguments['placeholder'],
                'value'         => $arguments['value']
        ]);
    }

    public function label(array $arguments): void
    {
        $this->add_element($arguments, 'label');
    }

    public function submit(mixed $arguments = false): void
    {
        if(!$arguments){
            $arguments = [
                    'id' => $this->id . '-submit'
            ];
        }

        $this->add_element($arguments, 'input', 'submit');
    }

    public function render(): void
    {
        ?>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="<?php echo $this->id ?>" method="POST">
            <input type="hidden" name="action" value="<?php echo $this->action; ?>">
            <input type="hidden" name="nonce" value="<?php echo $this->nonce; ?>">
            <?php
                $this->loop_inputs($this->inputs);
            ?>
        </form>
        <?php
    }

    private function add_element(array $arguments, string $element, mixed $type = false): void
    {
        if(!$this->validation($arguments)){
            wppl_dd('The required fields were not added to the form');
        }

        $pushable = [
            'element'       => $element,
            'id'            => $arguments['id'],
        ];

        if(isset($arguments['placeholder'])){
            $pushable['placeholder'] = $arguments['placeholder'];
        }

        if(isset($arguments['value'])){
            $pushable['value'] = $arguments['value'];
        }

        if(isset($arguments['name'])){
            $pushable['name'] = $arguments['name'];
        }

        if($element == 'label'){
            if(isset($arguments['for'])){
                $pushable['for'] = $arguments['for'];
            }

            if(isset($arguments['label'])){
                $pushable['label'] = $arguments['label'];
            }
        }

        if($type){
            $pushable['type'] = $type;
        }

        array_push($this->inputs, $pushable);
    }

    private function validation(array $arguments): bool
    {
        if(!isset($arguments['id'])){
            return false;
        }

        return true;
    }

    /**
     * The method that loops the inputs
     *
     * @param array $inputs - An array of inputs can either be with the Element of 'input' or 'drowpdown'
     *
     * @return void
     */

    private function loop_inputs(): void
    {
        foreach($this->inputs as $input){
            if(isset($input['label'])){
                $this->render_label($input);
            }

            if ($input['element'] == 'input'){
                $this->render_input($input);
            }

            if ($input['element'] == 'select'){
                $this->render_select($input);
            }
        }

    }

    /**
     * REQUIRED
     * - Type
     * - ID
     * - Name
     *
     * OPTIONAL
     * - Placeholder
     * - Value
     *
     * @param array $input
     * @return void
     */

    private function render_input(array $input): void
    {
        echo '<'. $input['element'] .' type="' . $input['type'] . '" id="'. $input['id'] . ((isset($input['name'])) ? $input['name'] : '') . '" ' . ((isset($input['placeholder'])) ? $input['placeholder'] : '') . ((isset($input['value'])) ? $input['value'] : '') . 'class="wppl-input ' . ((isset($input['class']) ? $input['class'] : '')) . (($input['type'] == 'submit' ? ' wppl-submit' : '')) .'">';
    }

    /**
     * REQUIRED
     * - Name
     * - ID
     * - Options - ARRAY OF AN ARRAYS FOR EVERY OPTION
     *
     * @param array $input
     * @return void
     */

    private function render_select(array $input): void
    {
        echo '<' . $input['element'] . ' name="' . $input['name'] . '" id="' . $input['id'] . 'class="wppl-input ' .((isset($input['class']) ? $input['class'] : '')) . '">';
        $this->option_loop($input['options']);
        echo '</'. $input['element'] . '>';
    }

    /**
     * REQUIRED
     * - Value
     * - ID
     * - Text
     *
     * @param array $options
     * @return void
     */

    private function option_loop(array $options): void
    {
        foreach($options as $option){
            echo '<option value="' . $option['value'] . '" id="'. $option['id'] . '">' . $option['text'] . '</option>';
        }
    }

    /**
     * Render the label
     *
     * REQUIRED
     * - Input
     *
     * @param array $input
     * @return void
     */

    private function render_label(array $input): void
    {
        echo '<label id="'. $input['id'] . '" class="wppl-input wppl-label ' . ((isset($input['class']) ? $input['class'] : '')) . '" for="' . $input['for'] . '">';
        echo $input['label'];
        echo '</label>';
    }

    /**
     * A helper that will check if the provided nonce is correct
     *
     * REQUIRED
     * - Nonce
     * - Tag
     * 
     * @param string $nonce
     * @param string $tag
     * @return void
     */

    static function check_nonce(string $nonce, string $tag): bool
    {
        if( wp_verify_nonce($nonce, $tag) ) {
            return true;
        }

        return false;
    }
}