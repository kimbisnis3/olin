<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** If empty null helper **/
if (!function_exists('status')) {
    function ien($text)
    {
        if ($text=='') {
            $text = NULL;
        }
        else {
            $text = $text;
        }
       
        return $text;
    }

    function dfh($text)
    {
        if ($text=='') {
            $text = NULL;
        }
        else {
            $text = date('Y-m-d', strtotime($text));
        }
       
        return $text;
    }

    function tip($text)
    {
        if ($text=='') {
            $text = NULL;
        }
        else {
            $text = $this->input->post($text);
        }
       
        return $text;
    }
}