<?php


namespace WPPL\Traits;

if ( ! trait_exists( 'WPPL_Database' ) ) {
	trait WPPL_Database {
		// Does the table exist?
		private function table_exists( $table_name ): bool {
			global $wpdb;

			$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

			if ( $wpdb->get_var( $query ) == $table_name ) {
				return true;
			}

			return false;
		}

		// Create a new table
		private function create_table( $table_name, $fields ) {
			if ( ! $this->table_exists( $table_name ) ) {
				global $wpdb;

				$charset = $wpdb->get_charset_collate();

				$formatted_table_name = $table_name;

				$sql = "CREATE TABLE $formatted_table_name ( $fields ) $charset;";

				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

				return dbDelta( $sql );
			}
		}

		// Format the table name
		private function generate_table_name( $name ): string {
			global $wpdb;

			$prefix = 'wppl';

			if ( defined( 'WPPL_DB_PREFIX' ) ) {
				$prefix = WPPL_DB_PREFIX;
			}

			return $wpdb->prefix . $prefix . '_' . $name;
		}
	}
}