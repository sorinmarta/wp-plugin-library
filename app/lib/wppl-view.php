<?php

if( ! class_exists( 'WPPL_View' ) ){
    class WPPL_View{
        private string $view;
        private $with;

        public function __construct( string $view, $with = false ) {
            $this->view = $view;

            if( $with ){
                $this->with = $with;
            }

            $this->render();
        }

        /**
         * Add the notifications partial
         *
         * @return void
         */
        private function add_notifications(): void {
            if( isset( $_COOKIE['wppl_redirect_type'] ) && isset( $_COOKIE['wppl_redirect_message'] ) ){
                $type = $this->generate_message_class( $_COOKIE['wppl_redirect_type'] );
                $message = $_COOKIE['wppl_redirect_message'];

                $this->show_redirect_message( $type, $message );
            }
        }

        /**
         * The notifications partial
         *
         * @param string $type
         * @param string $message
         * @return void
         */
        private function show_redirect_message( string $type, string $message ): void {
            ?>
            <div class="wppl-message-container">
                <div class="wppl-notice <?php echo $type; ?>">
                    <p><?php echo $message; ?></p>
                </div>
            </div>

            <script>
                document.cookie = "wppl_redirect_type=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "wppl_redirect_message=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            </script>
            <?php
        }

	    /**
	     * Generate which HTML class to assign
	     *
	     * @param string $type
	     *
	     * @return string
	     */
        private function generate_message_class( string $type ): string {
            switch ( $type ){
                case 'success':
                    return 'wppl-success';
                case 'alert':
                    return 'wppl-alert';
                case 'error':
                    return 'wppl-error';
            }
         }

        /**
         * Renders the page with the values passed
         *
         * @return void
         */
         private function render(): void {
             $this->add_notifications();

             if( ! empty( $this->with ) ){
                 foreach( $this->with as $key => $value ){
                     ${$key} = $value;
                 }
             }

	         require WPPL_PATH . '/app/views/' . $this->view . '.php';
         }
    }
}