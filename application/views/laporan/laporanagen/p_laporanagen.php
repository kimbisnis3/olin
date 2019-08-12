<?php 
$id = -1;
$no= 1;
foreach ($maintenance as $t) {

    if ($id != -1 && $id != $t->namaperalatan) {
        echo '</tbody>';
        echo '</table>';
        $no= 1;
    }

    if ($id != $t->namaperalatan) { ?>

        <table id="table" cellspacing="0" witdh="100%" class="table table-striped table-bordered">
        <?php echo '<thead><b>'.$t->namaperalatan.'</b></thead>'; ?> 
        <tr>
        <th>No. </th>
        <th>Tanggal</th>
        <th>Jenis Perawatan / Perbaikan</th>
        <th>Spare Part</th>
        <th>Keterangan</th>
        </tr>
        </thead>
        <tbody>

      <?php $id = $t->namaperalatan; } 
        $spart = $t->spart;
        $sparepart="";

        if ($spart == 't') {
          $sparepart=" Ya ";
        }
        else {
          $sparepart = "Tidak";
        }
      ?>

       <tr>
       <td width="2%"><?php echo $no ?></td>
       <td class="tdcenter"><?php echo id_date($t->tgl); ?></td>
       <td class="tdcenter"><?php echo $t->perbaikan; ?></td>
       <td width="10%"><?php echo $sparepart; ?></td>
       <td class="tdcenter"><?php echo $t->ket; ?></td>
       </tr>

  <?php $no++;}

echo '</tbody>';
echo '</table>';

?>

