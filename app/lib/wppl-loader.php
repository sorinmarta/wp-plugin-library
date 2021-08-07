<?php

class WPPL_Loader{
    public function __construct(){
        $this->require_lib();
    }

    private function require_lib(){
        require 'wppl-view.php';
    }
}

new WPPL_Loader();