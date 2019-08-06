<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function btnud($text)
{
    $text = ("<button type='button' class='btn btn-sm btn-warning btn-flat' data-toggle='tooltip' data-placement='top' title='Edit' onclick='edit_data(".$text.")'><i class='glyphicon glyphicon-pencil'></i></button>
    	<button type='button' class='btn btn-sm btn-danger btn-flat' data-toggle='tooltip' data-placement='top' title='Hapus' onclick='hapus_data(".$text.")'><i class='glyphicon glyphicon-trash'></i></button>");
 
    return $text;
}

function btnuda($text)
{
    $text = ("
    	<button type='button' class='btn btn-sm btn-warning btn-flat' data-placement='top' title='Edit' onclick='edit_data(".$text.")'><i class='glyphicon glyphicon-pencil'></i></button>
    	<button type='button' class='btn btn-sm btn-danger btn-flat' data-placement='top' title='Hapus' onclick='hapus_data(".$text.")'><i class='glyphicon glyphicon-trash'></i></button>
    	<button type='button' class='btn btn-sm btn-success btn-flat' data-placement='top' title='Aktif' onclick='aktif_data(".$text.")'><i class='glyphicon glyphicon-ok'></i></button>
    	");
 
    return $text;
}

function btnudax($text)
{
    $text = ("
        <button type='button' class='btn btn-sm btn-warning btn-flat' data-placement='top' title='Edit' onclick='edit_data(".$text.")'><i class='glyphicon glyphicon-pencil'></i></button>
        <button type='button' class='btn btn-sm btn-danger btn-flat' data-placement='top' title='Hapus' onclick='hapus_data(".$text.")'><i class='glyphicon glyphicon-trash'></i></button>
        <button type='button' class='btn btn-sm btn-success btn-flat' data-placement='top' title='Aktif' onclick='aktif_data(".$text.")'><i class='glyphicon glyphicon-ok'></i></button>
        <button type='button' class='btn btn-sm btn-primary btn-flat' data-placement='top' title='Unggulan' onclick='tampil_data(".$text.")'><i class='glyphicon glyphicon-star'></i></button>
        ");
 
    return $text;
}

function btnudavue($text)
{
    $text = ("
        <button type='button' class='btn btn-sm btn-warning btn-flat' data-placement='top' title='Edit' @click='edit_data(".$text.")'><i class='glyphicon glyphicon-pencil'></i></button>
        <button type='button' class='btn btn-sm btn-danger btn-flat' data-placement='top' title='Hapus' @click='hapus_data(".$text.")'><i class='glyphicon glyphicon-trash'></i></button>
        <button type='button' class='btn btn-sm btn-success btn-flat' data-placement='top' title='Aktif' @click='aktif_data(".$text.")'><i class='glyphicon glyphicon-ok'></i></button>
        ");
 
    return $text;
}

function btnu($text)
{
    $text = ("<button type='button' class='btn btn-sm btn-warning btn-flat' data-toggle='tooltip' data-placement='top' title='Edit' onclick='edit_data(".$text.")'><i class='glyphicon glyphicon-pencil'></i></button>");
 
    return $text;
}

function btnd($text)
{
    $text = ("
        <button type='button' class='btn btn-sm btn-danger btn-flat' data-placement='top' title='Hapus' onclick='hapus_data(".$text.")'><i class='glyphicon glyphicon-trash'></i></button>
        ");
 
    return $text;
}
 
?>