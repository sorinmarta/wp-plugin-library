<?php

if(!class_exists('WPPL_Enqueuing_Controller')){
	class WPPL_Enqueuing_Controller{
		public function __construct(){
			add_action('admin_enqueue_scripts', array($this, 'admin'));
		}

		public function admin(){
			wp_enqueue_style('wppl-main-stylesheet', \WPPL\WPPL_CSS . 'admin/main.css', null, false);
		}
		// string $handle, string $src = '', string[] $deps = array(), string|bool|null $ver = false, string $media = 'all'
		private function style(array $options){
			$this->options_validate($options);

			if(isset($options['slugs'])){
				return $this->filtered_enqueue($options, $options['slugs'], 'style');
			}

			wp_enqueue_style($options['handle'], $options['src'], $options['deps'], $options['ver'], $options['media']);
		}

		private function options_validate(array $options){
			if(!isset($options['handle']) || !is_string($options['handle'])){
				wp_die('Handle parameter needs to be added and must be a string');
			}

			if(!isset($options['src']) || !is_string($options['src'])){
				wp_die('Src parameter needs to be added and must be a string');
			}

			if(isset($options['deps'])){
				if(!is_array($options['deps'])){
					wp_die('Deps must be an array');
				}
			}

			if(isset($options['media'])){
				if(!is_string('media')){
					wp_die('Media must be a string');
				}
			}
		}

		private function filtered_enqueue(array $options, array $slugs, string $type){
			// Filter and enqueue

			return true;
		}
	}

	new WPPL_Enqueuing_Controller();
}