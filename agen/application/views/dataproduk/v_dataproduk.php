<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <style type="text/css">
  </style>
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
        <?php $this->load->view('dataproduk/m_dataproduk') ?>
          <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <div class="box box-info">
                  <div class="box-header">
                    <div class="pull-left">
                      <button class="btn btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                      <button class="btn btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="pull-right">
                      <button class="btn btn-biru btn-flat" onclick="image_data()"><i class="fa fa-image"></i> Gambar</button>
                      <!-- <button class="btn btn-hijau btn-flat" onclick="custom_data()"><i class="fa fa-check"></i> Status Produk</button> -->
                      <button class="btn btn-warning btn-flat edit-btn invisible" onclick="edit_data()"><i class="fa fa-pencil"></i> Ubah</button>
                      <button class="btn btn-danger btn-flat delete-btn invisible" onclick="hapus_data()" ><i class="fa fa-trash"></i> Hapus</button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive mailbox-messages">
                      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr id="repeat">
                            <th width="1%"></th>
                            <th width="5%">No</th>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Konv</th>
                            <th>Nama Satuan</th>
                            <th>Harga</th>
                            <th>Ket</th>
                            <th>Design</th>
                            <th>Kategori</th>
                            <th>Gambar Design</th>
                            <th>Warna</th>
                            <th>Custom</th>
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
  <?php $this->load->view('dataproduk/js_dataproduk') ?>

</body>
</html>
