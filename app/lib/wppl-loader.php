<?php

class WPPL_Loader{
    public function __construct(){
        $this->require_help();
        $this->require_lib();
    }

    private function require_lib(){
        require 'wppl-view.php';
        require 'wppl-form.php';
    }

    private function require_help(){
        require WPPL_PATH . '/app/helpers/wppl-helper.php';
    }
}

new WPPL_Loader();