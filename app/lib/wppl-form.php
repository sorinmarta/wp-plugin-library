<?php

namespace WPPL\Lib;

if(!class_exists('WPPL_Form')){
	class WPPL_Form{
		private string $action;
		private string $nonce;
		private array $inputs = [];
		private string $id;
		private string $element_value;

		/**
		 * The constructor function of the form class
		 *
		 * @param string $action
		 * @param mixed  $nonce
		 * @param mixed  $id
		 */
		public function __construct(string $action, $nonce = false, $id = false)
		{
			$this->action = $action;

			if($nonce){
				$this->nonce = wp_create_nonce($nonce);
			}else{
				$this->nonce = wp_create_nonce($action);
			}

			if(!$id){
				$this->id = uniqid('form-');
			}else{
				$this->id = $id;
			}
		}

		/**
		 * Adds a single text input to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function single_text(array $arguments): void
		{
			$this->add_element($arguments, 'input', 'text');
		}

		/**
		 * Adds a heading to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function heading(array $arguments, string $element): void
		{
			$this->add_element($arguments, $element);
		}

		/**
		 * Adds a paragraph to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function paragraph(array $arguments): void
		{
			$this->add_element($arguments, 'p');
		}

		/**
		 * Adds an email input to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function email(array $arguments): void
		{
			$this->add_element($arguments, 'input', 'email');
		}

		/**
		 * Adds a number input to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function number(array $arguments): void
		{
			$this->add_element($arguments, 'input', 'number');
		}

		/**
		 * Adds a textarea to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function textarea(array $arguments): void
		{
			$this->add_element($arguments, 'textarea');
		}

		/**
		 * Adds a select to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function select(array $arguments): void
		{
			$this->add_element($arguments, 'select');
		}

		/**
		 * Adds an option to a select element
		 *
		 * @param array  $arguments
		 * @param string $select_id
		 *
		 * @return void
		 */
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

		/**
		 * Adds a label to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function label(array $arguments): void
		{
			$this->add_element($arguments, 'label');
		}

		/**
		 * Adds a checkbox to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function checkbox($arguments): void
		{
			$this->add_element($arguments, 'input', 'checkbox');
		}

		/**
		 * Adds an editor to the form object
		 *
		 * @param array $arguments
		 *
		 * @return void
		 */
		public function editor($content, $id, $settings = array()){
			$this->add_element([
				'content' => $content,
				'id' => $id,
				'settings' => $settings
			], 'editor');
		}

		/**
		 * Adds a submit button to the form object
		 *
		 * @param mixed $arguments
		 *
		 * @return void
		 */
		public function submit($arguments = false): void
		{
			if(!$arguments){
				$arguments = [
					'id' => $this->id . '-submit'
				];
			}

			$this->add_element($arguments, 'input', 'submit');
		}

		/**
		 * Renders the form object as HTML
		 *
		 * @return void
		 */
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

		/**
		 * Adds an element to the inputs array of the form object
		 *
		 * @param array  $arguments
		 * @param string $element
		 * @param mixed  $type
		 *
		 * @return void
		 */
		private function add_element(array $arguments, string $element, $type = false): void
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

			if(isset($arguments['default'])){
				$pushable['default'] = $arguments['default'];
			}

			if(isset($arguments['class'])){
				$pushable['class'] = $arguments['class'];
			}

			if(isset($arguments['group'])){
				$pushable['group'] = $arguments['group'];
			}

			$pushable['checked'] = false;

			if(isset($arguments['checked'])){
				if($arguments['checked'] == 'true'){
					$pushable['checked'] = true;
				}
			}

			if($element == 'label'){
				if(isset($arguments['for'])){
					$pushable['for'] = $arguments['for'];
				}

				if(isset($arguments['label'])){
					$pushable['label'] = $arguments['label'];
				}
			}

			if(isset($arguments['content'])){
				$pushable['content'] = $arguments['content'];
			}

			if(isset($arguments['settings'])){
				$pushable['settings'] = $arguments['settings'];
			}


			if($type){
				$pushable['type'] = $type;
			}

			array_push($this->inputs, $pushable);
		}

		/**
		 * Validates if the form object has an ID
		 *
		 * @param array $arguments
		 *
		 * @return bool
		 */
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
		 * @return void
		 */
		private function loop_inputs(): void
		{
			foreach($this->inputs as $input){
				if(isset($input['label'])){
					$this->render_label($input);
				}

				if($input['element'] == 'input'){
					$this->render_input($input);
				}

				if($input['element'] == 'select'){
					$this->render_select($input);
				}

				if($input['element'] == 'editor'){
					$this->render_editor($input);
				}

				if (in_array($input['element'], ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'])){
					$this->render_text($input);
				}
			}

		}

		/**
		 * Renders an element from the elements array
		 *
		 * @param array $input
		 *
		 * @return void
		 */
		private function render_input(array $input): void
		{
			if(isset($input['group']) &&$input['group'] == 'start'){
				echo "<div class='wppl-form-group'>";
			}

			echo '<'. $input['element'] .' type="' . $input['type'] . '" id="'. $input['id'] . '"' . ((isset($input['name'])) ? 'name="' . $input['name'] . '"' : '') . ((isset($input['placeholder'])) ? $input['placeholder'] : '') . ((isset($input['value']) || isset($input['default'])) ?'value="' . $this->set_element_value($input) . '"' : '') . 'class="wppl-input ' . (( $input['class'] ?? '' )) . (( $input['type'] == 'submit' ? ' wppl-submit' : '')) . '"' . (($input['checked']) ? 'checked' : '') .'>';

			if(isset($input['group']) &&$input['group'] == 'end'){
				echo '</div>';
			}
		}

		/**
		 *  Renders the select object
		 *
		 * @param array $input
		 * @return void
		 */
		private function render_select(array $input): void
		{
			if(isset($input['group']) &&$input['group'] == 'start'){
				echo "<div class='wppl-form-group'>";
			}

			echo '<' . $input['element'] . ' name="' . $input['name'] . '" id="' . $input['id'] . 'class="wppl-input ' .((isset($input['class']) ? $input['class'] : '')) . '">';
			$this->option_loop($input['options']);
			echo '</'. $input['element'] . '>';

			if(isset($input['group']) &&$input['group'] == 'end'){
				echo '</div>';
			}
		}

		/**
		 * Loop through the options of a select item
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
		 * @param array $input
		 * @return void
		 */
		private function render_label(array $input): void
		{
			if(isset($input['group']) &&$input['group'] == 'start'){
				echo "<div class='wppl-form-group'>";
			}

			echo '<label id="'. $input['id'] . '" class="wppl-input wppl-label ' . ((isset($input['class']) ? $input['class'] : '')) . '" for="' . $input['for'] . '">';
			echo $input['label'];
			echo '</label>';

			if(isset($input['group']) &&$input['group'] == 'end'){
				echo '</div>';
			}
		}

        /*
         * Render the headings and paragraphs
         */
		private function render_text(array $input): void
		{
			if(isset($input['group']) && $input['group'] == 'start'){
				echo "<div class='wppl-form-group'>";
			}

			echo '<'. $input['element'] .' id="'. $input['id'] . '" class="wppl-heading wppl-form-heading ' . ((isset($input['class']) ? $input['class'] : '')) . '">';
			echo $input['content'];
			echo '</'. $input['element'] .'>';

			if(isset($input['group']) &&$input['group'] == 'end'){
				echo '</div>';
			}
		}

        /*
         * Render the editor field
         */
		private function render_editor($input){
			if(isset($input['group']) && $input['group'] == 'start'){
				echo "<div class='wppl-form-group'>";
			}

			wp_editor($input['content'], $input['id'], $input['settings']);

			if(isset($input['group']) &&$input['group'] == 'end'){
				echo '</div>';
			}
		}

        /*
         * Set the default value of the element
         */
		private function set_element_value(array $arguments): string
		{
			if(isset($arguments['default'])){
				if($arguments['default']){
					return $arguments['default'];
				}
			}

			if(isset($arguments['value'])){
				return $arguments['value'];
			}

			return '';
		}

		/**
		 * A helper that will check if the provided nonce is correct
		 *
		 * @param string $nonce
		 * @param string $tag
		 * @return bool
		 */
		static function check_nonce(string $nonce, string $tag): bool
		{
			if( wp_verify_nonce($nonce, $tag) ) {
				return true;
			}

			return false;
		}
	}
}