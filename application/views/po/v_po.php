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
        <?php $this->load->view('po/m_po'); ?>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-header bg">
                  <div class="pull-right box-tools">
                    <button class="btn btn-default btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div>
                  <i class="fa fa-search"></i>
                  <h3 class="box-title">
                  Filter Data
                  </h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Tanggal Awal</label>
                        <input type="text" class="form-control datepicker" name="filterawal">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="text" class="form-control datepicker" name="filterakhir">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>Agen</label>
                      <select class="form-control select2" name="filteragen" id="filteragen">
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label>Diproses</label>
                      <select class="form-control select2" name="filterproses" id="filterproses">
                        <option value=""></option>
                        <option value="1">Diproses</option>
                        <option value="0">Belum Diproses</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-header">
                  <div class="pull-left">
                    <button class="btn btn-act btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                    <button class="btn btn-act btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                  </div>
                  <div class="pull-right">
                    <button class="btn btn-act btn-warning btn-flat edit-btn invisible" onclick="edit_data()"><i class="fa fa-pencil"></i> Ubah</button>
                    <button class="btn btn-act bg-navy btn-flat file-btn" onclick="open_file()"><i class="fa fa-file"></i> File</button>
                    <button class="btn btn-act btn-danger btn-flat delete-btn invisible" onclick="hapus_data()" ><i class="fa fa-trash"></i> Void</button>
                    <button class="btn btn-act bg-olive btn-flat" onclick="cetak_data()" ><i class="fa fa-print"></i> Cetak</button>
                    <button class="btn btn-act btn-hijau btn-flat" onclick="cetak_spk()" ><i class="fa fa-print"></i> Cetak SPK</button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="table-responsive mailbox-messages">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr id="repeat">
                          <th width="5%"></th>
                          <th width="5%">No</th>
                          <th>ID</th>
                          <th>Kode</th>
                          <th>Tanggal</th>
                          <th>Agen</th>
                          <th>Layanan</th>
                          <th>Pengiriman</th>
                          <th>Keterangan</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
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
  <?php $this->load->view('po/js_po'); ?>

</body>
</html>