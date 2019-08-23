<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/lte/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/cetak_trx.css" rel="stylesheet"/>
  </head>
  <!-- <body onload="window.print()"> -->
<body>
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
            <div class="col-xs-3">
              <p>Kepada</p>
              <p>Alamat</p>
              <p>Telp</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-4">
              <p><?php echo $order->kirimke ?></p>
              <p><?php echo $order->alamat ?></p>
              <p><?php echo $order->telp ?></p>
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
              <p>Layanan</p>
            </div>
            <div class="col-xs-1">
              <p>:</p>
              <p>:</p>
              <p>:</p>
            </div>
            <div class="col-xs-5">
              <p><?php echo $order->kode ?></p>
              <p><?php echo normal_date($order->tgl) ?></p>
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
            <th>Spesifikasi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="width: 50%">
              <div>
                <div class="row">
                  <div class="col-xs-3">
                    <p>Kode </p>
                    <p>Produk</p>
                    <p>Jumlah</p>
                    <p>Harga</p>
                    <p>Total</p>
                  </div>
                  <div class="col-xs-1">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                  </div>
                  <div class="col-xs-4">
                    <p><?php echo $barang->kode ?></p>
                    <p><?php echo $barang->nama ?></p>
                    <p><?php echo $barang->jumlah ?></p>
                    <p><?php echo number_format($barang->harga) ?></p>
                    <p><strong><?php echo number_format($barang->subtotal) ?></strong></p>
                  </div>
                </div>
              </div>
            </td>
            <td style="width: 50%">
              <div>
                <div class="row">
                  <div class="col-xs-5">
                    <div style="padding: 10px;">
                      <?php echo showimagecustom($order->pathimage,'100') ?>
                    </div>
                  </div>
                  <div class="col-xs-7">
                    <div class="row">
                      <div class="col-xs-5">
                        <p>Kode </p>
                        <p>Warna<p>
                      </div>
                      <div class="col-xs-1">
                        <p>:</p>
                        <p>:</p>
                      </div>
                      <div class="col-xs-3">
                        <p><?php echo $spek->mmodesign_kode ?></p>
                        <p><?php echo $spek->mwarna_nama ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
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
                    <div class="row">
                      <div class="col-xs-5">
                        <p>Jasa Pengiriman </p>
                        <p>Alamat Kirim</p>
                        <p>Kota</p>
                        <p>Provinsi</p>
                        <p>Biaya Kirim</p>
                      </div>
                      <div class="col-xs-1">
                        <p>:</p>
                        <p>:</p>
                        <p>:</p>
                        <p>:</p>
                        <p>:</p>
                      </div>
                      <div class="col-xs-5">
                        <p><?php echo $order->kurir ?> ( <?php echo $order->kodekurir ?> )</p>
                        <p><?php echo $order->alamat ?></p>
                        <p><?php echo substr($order->lokasidari, strpos($order->lokasidari, "-") + 1);?></p>
                        <p><?php echo strtok($order->lokasidari, '-') ?></p>
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
                            <?php echo number_format($barang->subtotal + $order->bykirim) ?>
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