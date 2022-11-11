<?php

if(!class_exists('WPPL_Loader')) {
	class WPPL_Loader {
		public function __construct() {
			$this->help();
			$this->lib();
			$this->models();
			$this->controllers();
		}

		/**
		 * Requires all the library files
		 *
		 * @return $this
		 */
		private function lib() {
			foreach ( $this->get_files( WPPL_LIB ) as $file ) {
				require_once WPPL_LIB . "/$file";
			}

			return $this;
		}

		/**
		 * Requires all the helpers
		 *
		 * @return $this
		 */
		private function help() {
			foreach ( $this->get_files( WPPL_HELPER ) as $file ) {
				require_once WPPL_HELPER . "/$file";
			}

			return $this;
		}

		/**
		 * Requires all the models
		 *
		 * @return $this
		 */
		private function models() {
			foreach ( $this->get_files( WPPL_MODEL ) as $file ) {
				require_once WPPL_MODEL . "/$file";
			}

			return $this;
		}

		/**
		 * Requires all the controllers
		 *
		 * @return $this
		 */
		private function controllers() {
			foreach ( $this->get_files( WPPL_CONTROLLER ) as $file ) {
				require_once WPPL_CONTROLLER . "/$file";
			}

			return $this;
		}

		/**
		 * Loops through a directory and returns an array of PHP files
		 *
		 * @param $dir
		 *
		 * @return array
		 */
		private function get_files( $dir ): array {
			$dir_object = new \DirectoryIterator( $dir );
			$returnable = [];

			foreach ( $dir_object as $file ) {
				if ( $file->isDot() || $file->isDir() ) {
					continue;
				}

				if ( $file->getExtension() != 'php' ) {
					continue;
				}

				$returnable[] = $file->getFilename();
			}

			return $returnable;
		}
	}

	new WPPL_Loader();
}