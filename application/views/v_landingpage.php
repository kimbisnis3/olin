<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper" id="app">
      <?php $this->load->view('_partials/topbar'); ?>
      <?php $this->load->view('_partials/sidebar'); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1 class="title">
          <?php echo $title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active title"><?php echo $title; ?></li>
          </ol>
        </section>
      </div>
      <?php $this->load->view('_partials/foot'); ?>
    </div>
  </body>
</html>
<?php
  $this->load->view('_partials/js');
?>