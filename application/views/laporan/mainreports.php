<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url() ?>assets/cetak.css" rel="stylesheet"/>
  </head>
  <!-- <body onload="window.print()"> -->
  <body>
  <h2 class="judul"><?php echo (isset($title) ? $title : '') ?></h2>
  <h4><?php echo (isset($periodestart) ? 'Periode : '.$periodestart : ''); ?> <?php echo (isset($periodeend) ? 'Sampai : '.$periodeend : ''); ?></h4>
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
         <td><?php echo $t[$v]; ?></td>
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
         <td><?php echo $t[$v]; ?></td>
        <?php } ?>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php } ?>  
</body>
</html>