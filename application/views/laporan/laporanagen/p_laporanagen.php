<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/cetak.css" rel="stylesheet"/>
  </head>
  <body onload="window.print()">
  <h2 class="judul"><?php echo (isset($title) ? $title : '') ?></h2>
  <h4><?php echo (isset($periodestart) ? 'Periode : '.$periodestart : ''); ?> <?php echo (isset($periodeend) ? 'Sampai : '.$periodeend : ''); ?></h4>
  <h4><?php echo (isset($filter) ? $filter : ''); ?></h4>
<?php 
$id = 1;
foreach ($body as $i => $t) {

    if ($id != 1 && $id != $t->mjencust_nama) {
        echo '</tbody>';
        echo '</table>';
        $no= 1;
    }

    if ($id != $t->mjencust_nama) { ?>

      <?php echo '<p><b>'.$t->mjencust_nama.'</b></p>'; ?>
      <table>
      <tr>
        <th>No. </th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Telp</th>
        <th>Email</th>
        <th>Keterangan</th>
      </tr>
      </thead>
      <tbody>

      <?php $id = $t->mjencust_nama; } ?>

       <tr>
       <td width="2%"><?php echo $i + 1 ?></td>
       <td class="tdcenter"><?php echo $t->nama; ?></td>
       <td class="tdcenter"><?php echo $t->alamat; ?></td>
       <td width="10%"><?php echo $t->telp; ?></td>
       <td class="tdcenter"><?php echo $t->email; ?></td>
       <td class="tdcenter"><?php echo $t->ket; ?></td>
       </tr>

<?php }

echo '</tbody>';
echo '</table>';

?>

</body>
</html>