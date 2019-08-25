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
    <section class="header-report" style="margin-bottom: 40px">
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
              <p>Ref. PO</p>
              <p>Layanan</p>
              <p>Lama Pengerjaan</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-4">
              <p><?php echo $spk->ref_order ?></p>
              <p><?php echo $spk->mlayanan_nama ?></p>
              <p><?php 
              if ($spk->mlayanan_nama == "Normal") {
                  echo "10 Hari";
              }elseif ($spk->mlayanan_nama == "ONE DAY SERVICES") {
                  echo "1 Hari"; 
                }
              ?>
            </p>
            </div>
          </div>
        </div>
        <div class="col-xs-2">
        </div>
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-3">
              <p>Kode</p>
              <p>Tanggal</p>
              <p>Dateline</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $spk->kode ?></p>
              <p><?php echo normal_date($spk->tgl) ?></p>
              <p><?php echo normal_date(date('Y-m-d', strtotime($spk->tgl. ' + 10 days'))) ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section class="main-report" style="margin-bottom: 40px">
      <div class="row">
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-4">
              <p>Produk</p>
              <p>Model</p>
              <p>Jumlah</p>
              <p>Kode Design</p>
              <p>Warna</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
              <p>:</p>
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-4">
              <p><?php echo $barang->mbarang_nama ?></p>
              <p><?php echo $barang->mmodesign_nama ?></p>
              <p><?php echo $barang->jumlah ?> <?php echo $barang->satuan ?></p>
              <p><?php echo $barang->mmodesign_kode ?></p>
              <p><?php echo $barang->mwarna_nama ?></p>
            </div>
          </div>
        </div>
        <div class="col-xs-2">
        </div>
        <div class="col-xs-5">
          <div style="padding: 10px;">
            <?php echo imghandler($barang->pathimage,'100') ?>
          </div>
        </div>
      </div>
    </section>
    <section class="box-ttd" style="margin-bottom: 40px">
      <table>
        <thead>
          <tr>
            <th>Printing</th>
            <th>Cutting</th>
            <th>Sewing</th>
            <th>Finishing</th>
          </tr>
        </thead>
        <tbody>
          <tr class="tr-ttd">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr class="tr-ttd-nama">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</body>

<footer>
  <script src="<?php echo base_url()?>assets/lte/plugins/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/lte/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
</footer>
</html>