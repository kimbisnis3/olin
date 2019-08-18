<title><?php echo $title; ?></title>
<?php
  $this->load->view('template/head');
  $this->load->helper('indonesian_date');
  $this->load->helper('id_date');
  ?>
<style>
.konten {
  margin-top: 20px;
}
body {
  width: 90%;
  margin: 0 auto;
}
table {
  margin-bottom: 0px;
}
#table {
  border: 1px solid black;
}
#table th {
  background-color: #c8ccd1;
}
th, td {
    border: 1px solid black;
}
tr th {
  text-align: center;
}
img {
  width: 90%;
}
hr {
  border: 2px solid #0000BF;
}
@media print{@page {size: landscape}}
</style>
<div class="konten">
<body onload="window.print();">
<table>
  <tr>
    <th rowspan="4" style="width: 10%"><img src="<?php echo base_url('assets/utra.png'); ?>"></th>
    <th colspan="2" rowspan="2" style="text-align: center; color: #0000BF; font-size: 20px;">PT GUWATIRTA SEJAHTERA</th>
    <td style="width: 10%;">No Doc</td>
    <td></td>
  </tr>
  <tr>
    <td style="width: 10%;">Revisi</td>
    <td></td>
  </tr>
  <tr >
    <td colspan="2" rowspan="2" style="text-align: center; font-size: 18px;"><?php echo $title; ?></td>
    <td> Tanggal Cetak</td>
    <td style="width: 10%;"><?php echo indonesian_date(date("Y-m-d")) ; ?></td>
  </tr>
  <tr >
    <td >Halaman</td>
    <td></td>
  </tr>
</table>

<hr>
<p style="font-weight: bolder; font-size: 18px;">Periode : <?php echo $awal; ?> - <?php echo $akhir; ?></p> 
<?php 
$id = -1;
$no=1;

foreach ($rpp as $t) {

    if ($id != -1 && $id != $t->namaagen) {
        echo '</tbody>';
        echo '</table>';

    }

    if ($id != $t->namaagen) { ?>

        <table id="table" cellspacing="0" witdh="100%" class="table table-striped table-bordered">
        <?php echo '<thead><b>Departemen / Distrik : '.$t->namaagen.'</b></thead>'; ?> 
        <tr>
        <th>No. </th>
         <th>Tanggal</th>
           <th>Kode</th>
           <th>Supplier</th>
           <th>No Penawaran</th>
           <th>Petugas</th>
           <th>Keterangan</th>
        </tr>
        </thead>
        <tbody>

      <?php $id = $t->namaagen; } ?>

       <tr>
       <td width="2%"><?php echo $no ?></td>
       <td><?php echo id_date($t->tgl); ?></td>
       <td><?php echo $t->kodex; ?></td>
       <td><?php echo $t->namasup; ?></td>
       <td><?php echo $t->nopenawaran; ?></td>
       <td><?php echo $t->namakar; ?></td>
       <td><?php echo $t->ket; ?></td>
       </tr>

  <?php $no++;}

echo '</tbody>';
echo '</table>';

?>

<table class="pull-right">
  <tr>
    <td>Karanganyar, <?php echo indonesian_date(date("Y-m-d")) ; ?></td>
  </tr>
  <tr>
    <td style="height: 10%; padding: 15%;"></td>
  </tr>
  <tr>
    <td style="height: 10%; padding: 7%;"></td>
  </tr>
</table>
</body>
</div>
<script src="<?php echo base_url('assets/lte/plugins/jQuery/jQuery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets/lte/dist/js/de.js')?>"></script>
<script src="<?php echo base_url('assets/lte/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/lte/dist/js/app.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.15/se-1.2.2/datatables.min.js"></script>