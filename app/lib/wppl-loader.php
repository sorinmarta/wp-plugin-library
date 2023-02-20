<?php

if(!class_exists('WPPL_Loader')) {
	class WPPL_Loader {
		public function __construct() {
			$this->lib();
			$this->help();
            $this->abstracts();
            $this->interfaces();
			$this->models();
			$this->controllers();
		}

		/**
		 * Requires all the library files
		 */
		private function lib() {
			foreach ( $this->get_files( WPPL_LIB ) as $file ) {
				require_once $file;
			}
		}

		/**
		 * Requires all the helpers
		 */
		private function help() {
			foreach ( $this->get_files( WPPL_HELPER ) as $file ) {
				require_once $file;
			}
		}

		/**
		 * Requires all the models
		 */
		private function models() {
			foreach ( $this->get_files( WPPL_MODEL ) as $file ) {
				require_once $file;
			}
		}

		/**
		 * Requires all the controllers
		 */
		private function controllers() {
			foreach ( $this->get_files( WPPL_CONTROLLER ) as $file ) {
				require_once $file;
			}
		}

        /**
         * Requires all the interfaces
         */
        private function interfaces() {
            foreach ( $this->get_files( WPPL_INTERFACE ) as $file ) {
                require_once $file;
            }
        }

        /**
         * Requires all traits
         */
        private function abstracts() {
            foreach ( $this->get_files( WPPL_ABSTRACT ) as $file ) {
                require_once $file;
            }
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
			$returnable = array();

			foreach ( $dir_object as $file ) {
				if ( $file->isDot() ) {
					continue;
				}

				if ( $file->isDir() ){
					$returnable = array_merge($returnable, $this->get_files($dir . '/' .$file));
				}

				if ( $file->getExtension() != 'php' ) {
					continue;
				}

				$returnable[] = $dir . '/' .$file->getFilename();
			}

			return $returnable;
		}
	}

	new WPPL_Loader();
}