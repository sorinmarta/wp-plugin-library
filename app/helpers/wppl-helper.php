<?php

class WPPL_Helper{
    static function dd($value){
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }
}