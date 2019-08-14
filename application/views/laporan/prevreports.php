<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">
      <?php $this->load->view('_partials/topbar'); ?>
      <?php $this->load->view('_partials/sidebar'); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1 class="title"></h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active title"></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-body">
                  <form target="_blank" method="post" action="<?php echo current_url() ?>/cetak">
                    <div class="row">
                    <?php if (isset($filter_date) && $filter_date != '') { ?>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Awal</label>
                          <input type="text" class="form-control datepicker" name="awal">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Akhir</label>
                          <input type="text" class="form-control datepicker" name="akhir">
                        </div>
                      </div>
                    <?php }  ?>
                    <?php if (isset($gb) && $gb != '') { ?> 
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Group By</label>
                        <select class="form-control select2" name="gb">
                          <option value="">-</option>
                          <?php foreach ($gb as $i => $v): ?>
                            <option value="<?php echo $v->val ?>"><?php echo $v->label; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label style="color: #ffffff">zzzz</label>
                        <button @Click="refreshList" class="btn btn-success btn-flat btn-block"><i class="fa fa-print"></i> Cetak Laporan</button>
                      </div>
                    </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
        </div><!-- /.content-wrapper -->
        <?php $this->load->view('_partials/foot'); ?>
      </div>
    </body>
  </html>
  <?php $this->load->view('_partials/js'); ?>
  <script type="text/javascript">
  var title = '<?php echo $title ?>';

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('reports', title.replace(/ /g, "").toLowerCase());
      dpicker();
      setMonth('awal',30);
      setMonth('akhir',0);
      $('[name="gb"]').val()
  });


  </script>
</body>
</html>