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

    function normal_date($date)
    {
        if ($date != NULL) {
            
        $indonesian_month = array("Jan", "Feb", "Mar",
            "Apr", "May", "Jun",
            "Jul", "Aug", "Sep",
            "Oct", "Nov", "Dec");
        $year        = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
        $month       = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
        $currentdate = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
        $result = $currentdate . " " . $indonesian_month[(int) $month - 1] . " " . $year;

        return $result;
        }
    }

    function statuspo($s)
    {
        if ($s == 0) {
            $s = '<span class="label label-warning">Pending</span>';
        } else if($s >= 1 AND $s <= 3) {
            $s = '<span class="label label-primary">Produksi</span>';
        } else if($s == 4) {
            $s = '<span class="label label-success">Ready</span>';
        } else if($s >= 5) {
            $s = '<span class="label label-info">Dikirim</span>';
        }
       
        return $s;
    }

    //IMAGE MANIPULATION

    function showimage($i){
         
        if ($i == NULL){
            $i = "(Noimage)";
        } else {
            $img = base_url().''.$i;
            $i = "<img onerror='imgError(this)' style='max-width : 60px;' src='".$img."'>";
        }
        return $i;
    }

    function showimagecustom($i,$maxw){
        if ($i == NULL){
            $i = "(Noimage)";
        } else {
            $img = base_url().''.$i;
            $i = "<img style='max-width : ".$maxw."px;' src='".$img."'>";
        }

        return $i;
    }

    function dlimage($img){
        $path = ".".$img;
        if ($img == null || $img == "") {
            $img = "(Noimage)";
        } else {
            if (file_exists($path)) {
                $img = '<a href="'.$img.'" title="ImageName"  download="img_'.time().'" ><img style="max-width : 60px;" src="'.base_url().$img.'" alt="ImageName"></a>';
            } else {
                $img = "<img style='max-width : 60px;'  src='".base_url()."/assets/gambar/noimage.png'>";
            }
        }
        return $img;
    }

    function imgerr($img)
    {
        $path = ".".$img;

        if ($img == null || $img == "") {
            $img = "(Noimage)";
        } else {
            if (file_exists($path)) {
                $img = $img;
            } else {
                $img = '/assets/gambar/noimage.png';
            }
        }
        return $img;

        
    }

    function imghandler($img,$maxw)
    {
        $path = ".".$img;

        if ($img == null || $img == "") {
            $img = "(Noimage)";
        } else {
            if (file_exists($path)) {
                $img = "<img style='max-width : ".$maxw."px;' src='".base_url().$img."'>";
            } else {
                $img = "<img style='max-width : ".$maxw."px;'  src='".base_url()."/assets/gambar/noimage.png'>";
            }
        }
        return $img;

        
    }

}