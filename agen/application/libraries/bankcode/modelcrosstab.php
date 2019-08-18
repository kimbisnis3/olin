<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekappenawaranperiode extends CI_Model{

    function __construct() {
        parent::__construct();
        
    }
   
    function getSemua($awal, $akhir){
        $sql    = 
        "SELECT DISTINCT
            xpenawaran.ref_magen,
            magen.nama namaagen
        FROM
            xpenawaran
        LEFT OUTER JOIN mkaryawan ON mkaryawan.nik = xpenawaran.ref_kar
        LEFT OUTER JOIN msupplier ON msupplier.kode = xpenawaran.ref_sup
        LEFT OUTER JOIN magen ON magen.kode = xpenawaran.ref_magen";

        $sql    .= " WHERE
                xpenawaran.void IS NOT TRUE
            AND xpenawaran.validasi IS TRUE
            AND xpenawaran.tgl BETWEEN '$awal'
            AND '$akhir'";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getDetail($namaagen){
        $sql    = 
        "SELECT
            xpenawaran. ID,
            substr(xpenawaran.kode, 0, 9) kodex,
            xpenawaran.kode,
            xpenawaran.tgl,
            xpenawaran.ref_magen,
            magen.nama namaagen,
            xpenawaran.ref_kar,
            mkaryawan.nama namakar,
            CASE
        WHEN xpenawaran.ref_sup IS NOT NULL THEN
            msupplier.nama
        WHEN xpenawaran.ref_sup IS NULL THEN
            xpenawaran.supplier
        END namasup,
         xpenawaran.tglpenawaran,
         xpenawaran.nopenawaran,
         CASE
        WHEN xpenawaran.tipe = 0 THEN
            'Barang'
        WHEN xpenawaran.tipe = 1 THEN
            'Jasa'
        END tipex,
         xpenawaran.tipe,
         xpenawaran.ket,
         xpenawaran.ref_mmtransaksi,
         xpenawaran.validasi,
         xpenawaran.void
        FROM
            xpenawaran
        LEFT OUTER JOIN mkaryawan ON mkaryawan.nik = xpenawaran.ref_kar
        LEFT OUTER JOIN msupplier ON msupplier.kode = xpenawaran.ref_sup
        LEFT OUTER JOIN magen ON magen.kode = xpenawaran.ref_magen";

        $sql    .= " WHERE
            xpenawaran.void IS NOT TRUE
        AND magen.nama = '$namaagen'
        ORDER BY
                xpenawaran.tgl ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getcetak($awal, $akhir){
        $sql    = 
        "SELECT
            xpenawaran. ID,
            substr(xpenawaran.kode, 0, 9) kodex,
            xpenawaran.kode,
            xpenawaran.tgl,
            xpenawaran.ref_magen,
            magen.nama namaagen,
            xpenawaran.ref_kar,
            mkaryawan.nama namakar,
            CASE
        WHEN xpenawaran.ref_sup IS NOT NULL THEN
            msupplier.nama
        WHEN xpenawaran.ref_sup IS NULL THEN
            xpenawaran.supplier
        END namasup,
         xpenawaran.tglpenawaran,
         xpenawaran.nopenawaran,
         CASE
        WHEN xpenawaran.tipe = 0 THEN
            'Barang'
        WHEN xpenawaran.tipe = 1 THEN
            'Jasa'
        END tipex,
         xpenawaran.tipe,
         xpenawaran.ket,
         xpenawaran.ref_mmtransaksi,
         xpenawaran.validasi,
         xpenawaran.void
        FROM
            xpenawaran
        LEFT OUTER JOIN mkaryawan ON mkaryawan.nik = xpenawaran.ref_kar
        LEFT OUTER JOIN msupplier ON msupplier.kode = xpenawaran.ref_sup
        LEFT OUTER JOIN magen ON magen.kode = xpenawaran.ref_magen";

        $sql    .= " WHERE
                xpenawaran.void IS NOT TRUE
            AND xpenawaran.validasi IS TRUE
            AND xpenawaran.tgl BETWEEN '$awal'
            AND '$akhir'
            ORDER BY
                xpenawaran.tgl ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }

}