<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/lte/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- <link href="<?php echo base_url() ?>assets/cetak_trx.css" rel="stylesheet"/> -->
    <style type="text/css">

      .initial-report, .main-report {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 18px;
      }

      .main-report-sj {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 20px;
      }

      .box-bawah {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 18px;
      }

      td,
      th {
          border: 1px solid #616161;
          text-align: left;
          padding: 7px;
      }

      th {
          background-color: #e8e8e8;
      }

      .judul {
          text-align: center;
          text-decoration: underline !important;
      }

      .subjudul {
          text-align: center !important;
      }

      .tr-ttd > td {
          padding: 50px !important;
      }

      .tr-ttd-nama > td {
          padding: 15px !important;
      }

      hr{ 
        border: 0.5px solid black; 
      }
      @media print{@page {size: landscape}}
    </style>
  </head>
  <body onload="window.print()">
<!-- <body> -->
  <div class="container"> 
    <section class="header-report" style="margin-bottom: 20px">
      <div class="row">
        <div class="col-xs-12">
          <h3 class="judul"><?php echo $title ?></h3>
        </div>
      </div>
    </section>
    <section class="initial-report">
      <div class="row">
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-3">
              <p>Kode</p>
              <p>Tanggal</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-4">
              <p><?php echo $sj->kode ?></p>
              <p><?php echo $sj->tgl ?></p>
            </div>
          </div>
        </div>
        <div class="col-xs-2">
        </div>
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-3">
              <p></p>
            </div>
            <div class="col-xs-1">
              <p></p>
            </div>
            <div class="col-xs-4" ><strong>
              <p style="text-align: center; border: 1px solid black; padding: 5px;"><?php if ($sj->ref_kirim == 'GX0001') {
                echo "COD";
              } elseif ($sj->ref_kirim == 'GX0002') {
                echo strtoupper($sj->kurir);
              } else {
                echo "-";
              } ?></strong></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section class="main-report-sj" style="margin-bottom: 20px">
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-3">
              <p>Kepada</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
            </div>
            <div class="col-xs-4  ">
              <p><?php echo $sj->kirimke ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <p>Alamat</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
            </div>
            <div class="col-xs-4  ">
              <p><?php echo $sj->alamat ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <p>Kota</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
            </div>
            <div class="col-xs-4  ">
              <p><?php echo substr($sj->lokasike, strpos($sj->lokasike, "-") + 1);?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <p>Propinsi</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
            </div>
            <div class="col-xs-4  ">
              <p><?php echo strtok($sj->lokasike, '-') ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section style="margin-bottom: 40px" class="box-bawah">
      <div class="row">
        <div class="col-xs-7">
          <div class="row">
            <div class="col-xs-3">
              <p>Produk</p>
              <p>Jumlah</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-4">
              <p><?php echo $sj->mbarang_nama ?></p>
              <p><?php echo $sj->jumlah ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

<footer>
  <script src="<?php echo base_url()?>assets/lte/plugins/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/lte/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
</footer>
</html>