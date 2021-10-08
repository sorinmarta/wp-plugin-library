<?php

class WPPL_Loader{
    public function __construct(){
        $this->help();
        $this->lib();
        $this->models();
        $this->controllers();
    }

    private function lib(){
        require 'wppl-view.php';
        require 'wppl-form.php';
    }

    private function help(){
        require WPPL_PATH . '/app/helpers/wppl-helper.php';
    }

    private function models(){
        // Add your models
    }

    private function controllers(){
        // Add your controllers
    }
}

new WPPL_Loader();