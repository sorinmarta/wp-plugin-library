<?php

if(!class_exists('WPPL_Validator')){
    class WPPL_Validator{
        private object $model;
        private string $field;
        private string $error;
        private array $options;
        private bool $returnable;

        public function __construct($model, $field, $options)
        {
            $this->model = $model;
            $this->field = $field;
            $this->options = $options;
			$this->returnable = true;

            $this->validate();
        }

        public function validate()
        {
            foreach($this->options as $option){
                $this->individual_validation($option);

                if($this->returnable === false){
                    break;
                }
            }
        }

        public function result(): bool
        {
            return $this->returnable;
        }

        public function get_error(): string
        {
            if(!empty($this->error)){
                return $this->error;
            }

            return 'No error';
        }

        private function trigger_error($contents): void
        {
            $this->returnable = false;
            $this->error = __($this->field . ' ' . $contents, WPPL_SLUG);

        }

        private function individual_validation($option): void
        {
            switch ($option){
                case 'required':
                    $this->required($this->model->{$this->field});
                    return;
                case 'string':
                    $this->string($this->model->{$this->field});
                    return;
                case 'integer':
                    $this->integer($this->model->{$this->field});
                    return;
                case 'date':
                    $this->date($this->model->{$this->field});
                    return;
                case 'unique':
                    $this->unique($this->model->{$this->field});
                    return;
                default:
                    return;
            }
        }

        private function required($value): void
        {
            if(empty($value)){
                $this->trigger_error('must be a string');
            }

        }

        private function string($value): void
        {
            if(!is_string($value)){
                $this->trigger_error('must be a string');
            }

        }

        private function integer($value): void
        {
            if(!is_integer($value)){
                $this->trigger_error('must be a integer');
            }
        }

        private function date($value): void
        {
            if(!DateTime::createFromFormat(WPPL_TIME_FORMAT, $value)){
	            $this->trigger_error('must be a date');
            }

        }

        private function unique($value): void
        {
            global $wpdb;

            if($wpdb->get_row('SELECT * FROM '. $this->model->generate_table_name() .' WHERE ' . $this->field . '=' . $value)){
                $this->trigger_error('must be unique');
            }

        }
    }
}