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

    function dlimage($i){
         
        if ($i == NULL){
            $i = "(Noimage)";
        } else {
            $img = base_url().''.$i;
            $i = '<a href="'.$img.'" title="ImageName"  download="img_'.time().'" ><img style="max-width : 60px;" src="'.$img.'" alt="ImageName"></a>';
        }

        return $i;
    }

    function query_to_var($query,$filter) {
        $find       = array_keys($filter);
        $replace    = array_values($filter);
        $n          = str_replace($find, $replace, $query);
        return $n ;
    }

    function truefalse($data, $labeltrue, $labelfalse)
    {
        if ($data=='0' || $data=='NULL' || $data=='' || $data=='f') {
            $data = '<span class="label label-danger">'.$labelfalse.'</span>';
        }
        else {
            $data = '<span class="label label-success">'.$labeltrue.'</span>';
        }
       
        return $data;
    }

}