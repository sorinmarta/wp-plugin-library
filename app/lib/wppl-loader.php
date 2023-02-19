<?php

if(!class_exists('WPPL_Loader')) {
	class WPPL_Loader {
		public function __construct() {
			$this->lib();
            $this->help();
            $this->traits();
            $this->interfaces();
            $this->abstracts();
			$this->models();
			$this->controllers();
		}

		/**
		 * Requires all the library files
		 */
		private function lib(): void
        {
			foreach ( $this->get_files( WPPL_LIB ) as $file ) {
				require_once WPPL_LIB . "/$file";
			}
		}

		/**
		 * Requires all the helpers
		 */
		private function help(): void
        {
			foreach ( $this->get_files( WPPL_HELPER ) as $file ) {
				require_once WPPL_HELPER . "/$file";
			}
		}

		/**
		 * Requires all the models
		 */
		private function models(): void
        {
			foreach ( $this->get_files( WPPL_MODEL ) as $file ) {
				require_once WPPL_MODEL . "/$file";
			}
		}

		/**
		 * Requires all the controllers
		 */
		private function controllers(): void
        {
			foreach ( $this->get_files( WPPL_CONTROLLER ) as $file ) {
				require_once WPPL_CONTROLLER . "/$file";
			}
		}

        /**
         * Requires all the abstract classes
         */
        private function abstracts(): void
        {
            foreach ( $this->get_files( WPPL_ABSTRACT ) as $file ) {
                require_once WPPL_ABSTRACT . "/$file";
            }
        }

        /**
         * Requires all the traits
         */
        private function traits(): void
        {
            foreach ( $this->get_files( WPPL_TRAIT ) as $file ) {
                require_once WPPL_TRAIT . "/$file";
            }
        }

        /**
         * Requires all the interfaces
         */
        private function interfaces(): void
        {
            foreach ( $this->get_files( WPPL_INTERFACE ) as $file ) {
                require_once WPPL_INTERFACE . "/$file";
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