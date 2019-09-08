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
          <h4 class="subjudul"><?php echo $order->namacust ?></h4>
        </div>
      </div>
    </section>
    <section class="initial-report">
      <div class="row">
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-5">
              <p>Kepada</p>
            </div>
            <div class="col-xs-2">
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $this->libre->companydata()->nama ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-5">
              <p>Alamat</p>
            </div>
            <div class="col-xs-2">
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $this->libre->companydata()->alamat ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-5">
              <p>Telp</p>
            </div>
            <div class="col-xs-2">
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $order->telp ?></p>
            </div>
          </div>
        </div>
        <div class="col-xs-2">
        </div>
        <div class="col-xs-5">
          <div class="row">
            <div class="col-xs-5">
              <p>Kode</p>
            </div>
            <div class="col-xs-2">
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $order->kode ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-5">
              <p>Tanggal</p>
            </div>
            <div class="col-xs-2">
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo normal_date($order->tgl) ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-5">
              <p>Layanan</p>
            </div>
            <div class="col-xs-2">
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $order->mlayanan_nama ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <br>
    <section class="main-report">
      <table>
        <thead>
          <tr>
            <th>Produk</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table>
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Design</th>
                    <th>Warna</th>
                  </tr>
                  <?php foreach ($barang as $i => $v): ?>
                  <tr>
                      <td><?php echo $v->kode ?></td>
                      <td><?php echo $v->nama ?></td>
                      <td><?php echo $v->jumlah ?> <?php echo $v->satuan ?></td>
                      <td><?php echo number_format($v->harga) ?></td>
                      <td><?php echo number_format($v->subtotal) ?></td>
                      <td><?php echo $v->mmodesign_nama ?></td>
                      <td><?php echo $v->mwarna_nama ?></td>
                  </tr>
                  <?php endforeach ?>
                </thead>
              </table>
            </td>
          </tr>
          <tr>
            <th colspan="2">Pengiriman</th>
          </tr>
          <tr>
            <td colspan="2">
              <div>
                <div class="row">
                  <div class="col-xs-8">
                    <?php 
                      $colkiri = '4';
                      $coltengah = '2';
                      $colkanan = '6';
                    ?>  
                    <div class="row">
                      <div class="col-xs-<?php echo $colkiri ?>">
                        <p>Jasa Pengiriman </p>
                      </div>
                      <div class="col-xs-<?php echo $coltengah ?>">
                         <p>:</p>
                      </div>
                      <div class="col-xs-<?php echo $colkanan ?>">
                         <p><?php echo $order->kurir ?>  <?php echo "(". $order->kodekurir ?> )</p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-<?php echo $colkiri ?>">
                        <p>Alamat Kirim</p>
                      </div>
                      <div class="col-xs-<?php echo $coltengah ?>">
                        <p>:</p>
                      </div>
                      <div class="col-xs-<?php echo $colkanan ?>">
                        <p><?php echo $order->alamat ?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-<?php echo $colkiri ?>">
                        <p>Kota</p>
                      </div>
                      <div class="col-xs-<?php echo $coltengah ?>">
                        <p>:</p>
                      </div>
                      <div class="col-xs-<?php echo $colkanan ?>">
                        <p><?php echo substr($order->lokasike, strpos($order->lokasike, "-") + 1);?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-<?php echo $colkiri ?>">
                        <p>Provinsi</p>
                      </div>
                      <div class="col-xs-<?php echo $coltengah ?>">
                        <p>:</p>
                      </div>
                      <div class="col-xs-<?php echo $colkanan ?>">
                        <p><?php echo strtok($order->lokasike, '-') ?></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-<?php echo $colkiri ?>">
                        <p>Biaya Kirim</p>
                      </div>
                      <div class="col-xs-<?php echo $coltengah ?>">
                        <p>:</p>
                      </div>
                      <div class="col-xs-<?php echo $colkanan ?>">
                        <p><?php echo number_format($order->bykirim) ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-3">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="row box-total">
                          <div class="col-xs-4">
                            TOTAL
                          </div>
                          <div class="col-xs-1">
                            :
                          </div>
                          <div class="col-xs-5">
                            <?php echo number_format($order->total ) ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
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