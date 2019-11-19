<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/lte/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/cetak_trx.css" rel="stylesheet"/>
    <style type="text/css">
      .title-spk {
        font-weight: bolder
      }
      body {
        font-weight: bolder
      }
      .bg-grey {
        background-color: #ebebe0 !important
      }
      table {
        border: none !important
      }
      th, td {
        border: none !important;
        font-size: 18px !important
      }
      @media print {
        .bg-grey {
          background-color: #ebebe0 !important
        }
      }
    </style>
  </head>
  <body onload="window.print()">
<!-- <body> -->
  <div class="container" style="padding: 20px !important; border: 2px solid black !important; "> 
    <section>
      <div class="row">
        <div class="col-xs-4"><img src="<?php echo base_url() ?>assets/gambar/logoapp.png"></div>
        <div class="col-xs-4"></div>
        <div class="col-xs-4"><h3 class="title-spk"><?php echo $title ?></h3></div>
      </div>
      <div class="row" style="margin-top: 20px !important; font-size: 18px !important">
        <div class="col-xs-6">
          <div class="row">
            <div class="col-xs-4">No. SPK</div>
            <div class="col-xs-1">:</div>
            <div class="col-xs-7"><?php echo $order->kode; ?></div>
          </div>
        </div>
      </div>
      <div class="row" style="margin-top: 20px !important; font-size: 18px !important">
        <div class="col-xs-6">
          <div class="row">
            <div class="col-xs-12">
              JENIS ORDER :
            </div>
            <div class="col-xs-12 text-center">
              <p class="bg-grey">KANTONG</p>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
          <div class="row">
            <div class="col-xs-12">
              QTY :
            </div>
            <div class="col-xs-12 text-center">
              <p class="bg-grey"><?php echo $qty->qty; ?></p>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
          <div class="row">
            <div class="col-xs-12">
              DATELINE :
            </div>
            <div class="col-xs-12 text-center">
              <p class="bg-grey"><?php echo normal_date($order->tgl); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="margin-top: 20px !important; font-size: 18px !important">
        <div class="col-xs-6">
          <div class="row">
            <?php foreach ($spek as $i => $v): ?>
              <div class="col-xs-6">
                <div class="card">
                  <div class="card-header"><p class="bg-grey" style="font-size: 12px !important"><?php echo $v->nama; ?></p></div>
                  <div class="card-body">
                    <img src="<?php echo base_url().$v->mmodesign_gambar; ?>">
                  </div>
                </div>
                <!-- <table>
                  <tr>
                    <?php foreach ($masterwarna as $i => $v): ?>
                      <td><?php echo substr($v->nama, 0, 1); ?></td>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                  </tr>
                </table> -->
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="row">
            <div class="col-xs-12">
              <p class="bg-grey">TOTAL PENGGUNAAN BB</p>
            </div>
            <div class="col-xs-12">
              <table>
                <?php foreach ($warna as $i => $v): ?>
                  <tr>
                    <td><?php echo $v->nama; ?></td>
                    <td>:</td>
                    <td><?php echo $v->jumlah; ?></td>
                  </tr>
                <?php endforeach ?>
              </table>
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