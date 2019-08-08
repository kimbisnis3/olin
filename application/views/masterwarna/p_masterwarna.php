<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<link href="<?php echo base_url() ?>assets/cetak.css" rel="stylesheet"/>
</head>
<body>
	<h2 class="judul"><?php echo (isset($title) ? $title : '') ?></h2>
	<h4><?php echo (isset($periodestart) ? 'Periode : '.$periodestart : ''); ?> <?php echo (isset($periodeend) ? 'Sampai : '.$periodeend : ''); ?></h4>
	<h4><?php echo (isset($filter) ? $filter : ''); ?></h4>
	<table>
		<thead>
			<tr>
			<?php foreach ($header as $i => $v) {  ?>
				<th><?php echo $v ?></th>
			<?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($body as $i => $v) {  ?>
			<tr>
				<td><?php echo $i + 1; ?>. </td>
				<td><?php echo $v->kode; ?> </td>
				<td><?php echo $v->nama; ?> </td>
				<td><?php echo $v->colorc; ?> </td>
				<td><?php echo $v->ket; ?> </td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</body>
</html>