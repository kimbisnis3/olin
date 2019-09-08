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
      <?php 
        $colkiri = '4';
        $coltengah = '2';
        $colkanan = '6';
      ?>  
      <div class="row">
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Ref. PO</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $spk->ref_order ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Layanan</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $spk->mlayanan_nama ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Lama Pengerjaan</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php 
              if ($spk->mlayanan_nama == "Normal") {
                  echo "10 Hari";
              }elseif ($spk->mlayanan_nama == "ONE DAY SERVICES") {
                  echo "1 Hari"; 
                }
              ?></p>
            </div>
          </div>
        </div>

        <div class="col-xs-2">
        </div>
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Kode</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $spk->kode ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Tanggal</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo normal_date($spk->tgl) ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Dateline</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
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
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Kode Produk</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $barang->mbarang_kode ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Produk</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $barang->mbarang_nama ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Model</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $barang->mmodesign_nama ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Jumlah</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
              <p><?php echo $barang->jumlah ?> <?php echo $barang->satuan ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-<?php echo $colkiri ?>">
              <p>Warna</p>
            </div>
            <div class="col-xs-<?php echo $coltengah ?>">
              <p>:</p>
            </div>
            <div class="col-xs-<?php echo $colkanan ?>">
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
            <th style="text-align: center !important;">Printing</th>
            <th style="text-align: center !important;">Cutting</th>
            <th style="text-align: center !important;">Sewing</th>
            <th style="text-align: center !important;">Finishing</th>
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