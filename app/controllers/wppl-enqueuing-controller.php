<?php

if(!class_exists('WPPL_Enqueuing_Controller')){
	class WPPL_Enqueuing_Controller{
		public function __construct(){
			add_action('admin_enqueue_scripts', array($this, 'admin'));
//			add_action('wp_enqueue_scripts', array($this, 'front'));
		}

		public function front(){
			wp_enqueue_style('wppl-public-stylesheet', \WPPL\WPPL_CSS . 'public/main.css', null, false);
		}

		public function admin(){
			wp_enqueue_style('wppl-admin-stylesheet', \WPPL\WPPL_CSS . 'admin/main.css', null, false);
		}

		private function style(array $options){
			$options = $this->options_validate($options);

			if(isset($options['slugs'])){
				return $this->filtered_enqueue($options, $options['slugs'], 'style');
			}

			wp_enqueue_style($options['handle'], $options['src'], $options['deps'], $options['ver'], $options['media']);
		}

		private function script(array $options){
			$options = $this->options_validate($options);

			if(isset($options['slugs'])){
				return $this->filtered_enqueue($options, $options['slugs'], 'script');
			}

			wp_enqueue_script($options['handle'], $options['src'], $options['deps'], $options['ver'], $options['in_footer']);
		}

		private function options_validate(array $options): array
		{
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
			}else{
				$options['deps'] = null;
			}

			if(isset($options['media'])){
				if(!is_string('media')){
					wp_die('Media must be a string');
				}
			}else{
				$options['media'] = 'all';
			}

			if(isset($options['in_footer'])){
				if(!is_bool($options['in_footer'])){
					wp_die('in_footer must be a boolean');
				}
			}else{
				$options['in_footer'] = false;
			}

			return $options;
		}

		private function filtered_enqueue(array $options, array $slugs, string $type): bool
		{
			global $post;

			if(in_array($post->post_name, $slugs)){
				if($type === 'style'){
					wp_enqueue_style($options['handle'], $options['src'], $options['deps'], $options['ver'], $options['media']);

					return true;
				}

				if($type === 'script'){
					wp_enqueue_script($options['handle'], $options['src'], $options['deps'], $options['ver'], $options['in_footer']);

					return true;
				}
			}

			return false;
		}
	}

	new WPPL_Enqueuing_Controller();
}