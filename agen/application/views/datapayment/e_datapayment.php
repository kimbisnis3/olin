<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <style media="screen">
      table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 12px;
      }

      .initial-report, .main-report {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 12px;
      }

      .main-report-sj {
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
    </style>
  </head>
  <body onload="window.print()">
    <div class="container">
      <section>
        <h4>Pesanan Tervalidasi</h4>
      </section>
      <section class="main-report">
        <table>
          <thead>
            <tr>
              <th>No. PO</th>
              <th>Model Tas</th>
              <th>QTY Order</th>
              <th>Dateline</th>
              <th>Link Design</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dataorder as $i => $v): ?>
              <tr>
                <td><?php echo $v['kode']; ?></td>
                <td><?php echo $v['nama']; ?></td>
                <td><?php echo $v['jumlah']; ?></td>
                <td><?php echo normal_date($v['tglposted']); ?></td>
                <td><a href="<?php echo lumise_url().'editor.php?product='.$v['_product_id'].'&design_print='.$v['_design_id'].'&order_print='.$v['_order_id'].'/' ?>"><button type="button" class="btn btn-md btn-success">Link Design</button></a></td>
                <!-- http://localhost/lumise_new/editor.php?product=2&design_print=2019/11/jWYM98fgdi&order_print=121 -->
              </tr>
            <?php endforeach; ?>
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
