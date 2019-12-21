<?php
if ($this->input->post('aksi_button') == 'xls') {
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=".$title.".xls");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/cetak.css" rel="stylesheet"/>
  </head>
  <body onload="window.print()">
  <!-- <body> -->
  <h2 class="judul"><?php echo (isset($title) ? $title : '') ?></h2>
  <h4><?php echo (isset($periodestart) ? 'Periode : '.$periodestart : ''); ?> <?php echo (isset($periodeend) ? '- '.$periodeend : ''); ?><?php echo (isset($maskgb) && $maskgb != '' && $maskgb != null ? ' || Group By : '.$maskgb : '') ?></h4>
  <h4><?php echo (isset($filter) ? $filter : ''); ?></h4>

<?php if (isset($gb) && $gb != '' && $gb != null){ ?>
<?php
$id = 1;
foreach ($result as $index => $t) {

    if ($id != 1 && $id != $t[$gb]) {
        echo '</tbody>';
        echo '</table>';
    }

    if ($id != $t[$gb]) { ?>

      <?php echo '<p><b>'.$t[$gb].'</b></p>'; ?>
      <table>
      <tr>
        <th>No. </th>
        <?php foreach ($header as $i => $v) : ?>
        <th><?php echo $v; ?></th>
        <?php endforeach; ?>
      </tr>
      </thead>
      <tbody>

      <?php $id = $t[$gb]; } ?>

       <tr>
         <td width="2%"><?php echo $index + 1 ?></td>
         <?php foreach ($body as $i => $v) { ?>
         <td><?php echo is_numeric($t[$v]) ? number_format($t[$v]) : $t[$v]; ?></td>
         <?php } ?>
       </tr>

<?php }

echo '</tbody>';
echo '</table>';

?>
<?php } else { ?>
  <table>
    <thead>
      <tr>
        <th>No. </th>
      <?php foreach ($header as $i => $v) {  ?>
        <th><?php echo $v ?></th>
      <?php } ?>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $i => $t) {  ?>
      <tr>
        <td><?php echo $i + 1; ?>. </td>
        <?php foreach ($body as $i => $v) { ?>
         <td><?php echo is_numeric($t[$v]) ? number_format($t[$v]) : $t[$v]; ?></td>
        <?php } ?>
      </tr>
    <?php } ?>
    </tbody>

    <!-- Total -->
    <tbody style="display : <?php echo isset($usetotal) ? "": "none";?>">
    <tr></tr>
    <?php $sum = 0; ?>
    <?php foreach ($result as $i => $t) {  ?>
      <tr style="display : <?php echo ($i + 1) != count($result) ? "none": "";?>">
        <td><strong>TOTAL</strong></td>
        <?php foreach ($body as $i => $v) { ?>
         <td><strong><?php echo is_numeric($t[$v]) ? number_format($sum += $t[$v]) : ''; ?></strong></td>
        <?php } ?>
      </tr>
    <?php } ?>
    </tbody>

  </table>
<?php } ?>
</body>
</html>
