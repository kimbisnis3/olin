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

    function checkcolor($text)
    {
        if ($text=='t') {
            $text = '<span class="label label-success" style="align: center;"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i></span>';
        }
        else {
            $text = '<span class="label label-danger" style="align: center;"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i></span>';
        }
       
        return $text;
    }

    function showimage($i){
         
        if ($i == NULL){
            $i = "(Noimage)";
        } else {
            $img = base_url().''.$i;
            $i = "<img style='max-width : 60px;' src='".$img."'>";
        }

        return $i;
    }

    // <a href='javascript:void(0)' class='btn btn-sm btn-info' data-toggle='tooltip' data-placement='top' title='Unduh' onclick='unduh_data(".$r->id.")'><i class='glyphicon glyphicon-download-alt'></i></a>
}