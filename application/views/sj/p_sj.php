<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/lte/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/cetak_trx.css" rel="stylesheet"/>
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
              <p>Alamat</p>
              <p>Kota</p>
              <p>Propinsi</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-4">
              <p><?php echo $sj->kirimke ?></p>
              <p><?php echo $sj->alamat ?></p>
              <p><?php echo substr($sj->lokasidari, strpos($sj->lokasidari, "-") + 1);?></p>
              <p><?php echo strtok($sj->lokasidari, '-') ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section style="margin-bottom: 40px">
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