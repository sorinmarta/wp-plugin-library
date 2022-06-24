<?php

function wppl_dd($body): void
{
    \WPPL\Helpers\WPPL_Helper::dd($body);
}

function wppl_redirect($url, $type = null, $message = null): void
{
    \WPPL\Helpers\WPPL_Helper::redirect($url, $type, $message);
}