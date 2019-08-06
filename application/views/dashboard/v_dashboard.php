<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php
    $this->load->view('template/head');
    ?>
    <!--tambahkan custom css disini-->
    <style type="text/css">
    </style>
    <?php
    $this->load->view('template/topbar');
    $this->load->view('template/sidebar');
    ?>
    <section class="content-header">
      <h1>
      <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>
    
    <?php
    $this->load->view('template/js');
    ?>
    <script>
    $( ".<?php echo $aktifgrup ?>" ).addClass( "active" );
    </script>
    <script>
    $( ".<?php echo $aktifmenu ?>" ).addClass( "active" );
    </script>
    <?php
    $this->load->view('template/sidebar_theme');
    ?>
  </body>
</html>