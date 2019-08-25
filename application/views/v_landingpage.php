<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <body class="hold-transition skin-blue sidebar-mini">
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
        <section class="content fadeIn animated">
          <div class="row">
            <div class="col-md-4">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $po_pending->count ?></h3>
                  <p>PO Pending</p>
                </div>
                <div class="icon">
                  <i class="fa fa-exchange swing animated"></i>
                </div>
                <a href="<?php echo base_url() ?>po" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $po_proses->count ?></h3>
                  <p>PO Dalam Proses Produksi</p>
                </div>
                <div class="icon">
                  <i class="fa fa-refresh"></i>
                </div>
                <a href="<?php echo base_url() ?>po" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $po_ready->count ?></h3>
                  <p>PO Siap Kirim</p>
                </div>
                <div class="icon">
                  <i class="fa fa-check bounceIn animated"></i>
                </div>
                <a href="<?php echo base_url() ?>po" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php $this->load->view('_partials/foot'); ?>
    </div>
  </body>
</html>
<?php $this->load->view('_partials/js'); ?>
<script type="text/javascript">
  $(".title").html("Dashboard");
</script>