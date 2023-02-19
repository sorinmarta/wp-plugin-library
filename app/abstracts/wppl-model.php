<?php

if(!class_exists('WPPL_Model')){
    abstract class WPPL_Model{
        protected string $table;
        protected array $fields;
        protected string $error;

		public function __construct($id = false)
		{
			if(!$id){
				return $this->new();
			}else{
				if($this->exists($id)){
					return $this->load_by_id($id);
				}else{
					return $this->new();
				}
			}
		}

	    public function generate_table_name( $name = false ): string
        {
            global $wpdb;

            $prefix = 'wppl';

            if ( defined( 'WPPL_DB_PREFIX' ) ) {
                $prefix = WPPL_DB_PREFIX;
            }

            if(!empty($this->table)){
                return $wpdb->prefix . $prefix . '_' . $this->table;
            }

            return $wpdb->prefix . $prefix . '_' . $name;
        }

        public function exists($id): bool
        {
            global $wpdb;

            if ($wpdb->get_row('SELECT * FROM ' . $this->generate_table_name($this->table) . ' WHERE id=' . $id)) {
                    return true;
            }

            return false;
        }

        public function load_by_id($id)
        {
            global $wpdb;

            $object = $wpdb->get_results('SELECT * FROM ' . $this->generate_table_name() . ' WHERE id=' . $id . ';');

            if($object){
                $this->object_format($object);

                return $this;
            }

            return false;
        }

        public function save()
        {
            if($this->validation()){
                global $wpdb;

                $data = $this->array_format();

                if(empty($this->id) || !$this->exists($this->id)) {
					$wpdb->insert($this->generate_table_name(), $data );
                }else{
                    $wpdb->update($this->generate_table_name(), $data, ['id' => $this->id]);
                }

                $this->object_format(array($this->load_by_id($wpdb->insert_id)));

                return $this;
            }else{
                wp_die($this->error);
            }
        }

        protected function table_exists( $table_name ): bool
        {
            global $wpdb;

            $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

            if ( $wpdb->get_var( $query ) == $table_name ) {
                return true;
            }

            return false;
        }

        protected function create_table( $table_name, $fields ): void
        {
            if ( ! $this->table_exists( $table_name ) ) {
                global $wpdb;

                $charset = $wpdb->get_charset_collate();
                $sql = "CREATE TABLE $table_name ( $fields ) $charset;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

                dbDelta( $sql );
            }
        }

		protected function new(): self
		{
			foreach ($this->fields as $field => $rules){
				if($field === 'id'){
					continue;
				}

				if(is_array($rules)) {
					if ( in_array( 'string', $rules ) ) {
						$this->{$field} = '';
					} else if ( in_array( 'integer', $rules ) ) {
						$this->{$field} = 0;
					} else if ( in_array( 'date', $rules ) ) {
						$today = ( new DateTime() )->setTimestamp( time() );

						$this->{$field} = $today->format( WPPL_TIME_FORMAT );
					} else {
						$this->{$field} = null;
					}
				}else{
					$this->{$field} = null;
				}
			}

			return $this;
		}

        private function get_fields(): array
        {
            if(isset($this->fields)){
                $returnable = array();

                foreach($this->fields as $key => $field){
                    $returnable[] = $key;
                }

                return $returnable;
            }

            return array(
                'error' => 'There are no fields to be retrieved'
            );
        }

        private function validation(): bool
        {
            foreach($this->fields as $field => $options){
				if($field === 'id'){
					continue;
				}

				if(!is_array($options)){
					$options = array();
				}

                $validator = new WPPL_Validator($this ,$field, $options);

                if(!$validator->result()){
                    $this->error = $validator->get_error();

                    return false;
                }
            }

            return true;
        }

        private function object_format($object)
        {
            $fields = $this->get_fields();

			$this->id = $object[0]->id;

            foreach($fields as $field){
                $this->{$field} = $object[0]->{$field};
            }
        }

        private function array_format(): array
        {
            $returnable = array();
            $fields = $this->get_fields();

            foreach($fields as $field){
				if($field === 0 || $field === 'id'){
					continue;
				}

                $returnable[$field] = $this->{$field};
            }

            return $returnable;
        }
    }
}