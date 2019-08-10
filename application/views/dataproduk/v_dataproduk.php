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
        <div class="modal fade" id="modal-table-spek" role="dialog" data-backdrop="static">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <div class="box">
                  <div class="box-header">
                    <div class="pull-left">
                      <button class="btn btn-success btn-flat refresh-btn" onclick="refreshspek()"><i class="fa fa-refresh"></i> Refresh</button>
                      <button class="btn btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                  </div>
                  <div class="box-body pad">
                    <div class="table-responsive mailbox-messages">
                      <table id="table-spek" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr id="repeat">
                            <th width="5%">No</th>
                            <th>ID</th>
                            <th>No. Seri</th>
                            <th>Produk</th>
                            <th>Ket</th>
                            <th>Design</th>
                            <th>Gambar</th>
                            <th>Warna</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
          </div>  <!-- END MODAL SPEK-->
          <div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                  <div class="box-body pad">
                    <form id="form-data">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Kode Design</label>
                            <input type="hidden" name="id">
                            <input type="hidden" name="ref_brg">
                            <input type="text" class="form-control" name="sn">
                          </div>
                          <div class="form-group">
                            <label>Model</label>
                            <select class="form-control select2" name="model">
                              <option value="">-</option>
                              <?php foreach ($design as $i => $v): ?>
                              <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Warna</label>
                            <select class="form-control select2" name="warna">
                              <option value="">-</option>
                              <?php foreach ($warna as $i => $v): ?>
                              <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" name="ket">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
                  <button type="button" id="btnSave" onclick="savedata()" class="btn btn-primary btn-flat">Simpan</button>
                </div>
              </div>
            </div>
            </div>  <!-- END MODAL INPUT-->
            <div id="modal-konfirmasi" class="modal fade" role="dialog">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <center><h4 class="modal-title"></h4></center>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tidak</button>
                    <button type="button" id="btnHapus" class="btn btn-danger btn-flat">Ya</button>
                  </div>
                </div>
              </div>
            </div>
            <section class="content">
              <div class="row">
                <div class="col-xs-12">
                  <div class="box box-info">
                    <div class="box-header">
                      <div class="pull-left">
                        <button class="btn btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                        <button class="btn bg-maroon btn-flat add-btn invisible" onclick="open_spek()" ><i class="fa fa-bars"></i> Spek</button>
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
                              <th>ID Barang</th>
                              <th>Kode Barang</th>
                              <th>Nama Barang</th>
                              <th>Konv</th>
                              <th>Nama Satuan</th>
                              <th>Harga</th>
                              <th>Nama Gudang</th>
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
  <script type="text/javascript">
  var path = 'dataproduk';
  var title = 'Data Produk';
  var grupmenu = 'Master Data';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var idz     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('masterdata', 'dataproduk');

      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {},
          },
          "columns": [{ 
              "className": 'details-control',
              "orderable": false,
              "data": null,
              "defaultContent": ''
          },
          { "data": "no" }, 
          { "data": "id" , "visible" : false},
          { "data": "idbarang" , "visible" : false},
          { "data": "kodebarang" , "visible" : false},
          { "data": "namabarang" },
          { "data": "konv" },
          { "data": "namasatuan" },
          { "data": "harga" },
          { "data": "namagudang" },
          ]
      });

    $('#table tbody').on('click', '.odd', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            idx = -1;
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            if (table.row(this).index() > -1) {
                idx = table.row(this).index();
            }
        }
    });

    $('#table tbody').on('click', '.even', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            idx = -1;
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            if (table.row(this).index() > -1) {
                idx = table.row(this).index();
            }
        }
    });

    $('#table tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            format(row.child, row.data());
            tr.addClass('shown');
        }
    });
  });

  function format(callback, data) {
      $.ajax({
          url: `${apiurl}/getdetail`,
          type: "POST",
          data: {
            kodebarang : data.kodebarang
          },
          success: function(response) {
              callback($(response)).show();
          },
          error: function() {
              $('#output').html('Bummer: there was an error!');
          }
      });
  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function refreshspek() {
      tablespek.ajax.reload(null, false);
      idz = -1;
  }

  function open_spek() {
      if (idx == -1) {
          return false;
      }
      $('#modal-table-spek').modal('show');
      $('.modal-title').text('Spesifikasi Produk');
      tablespek = $('#table-spek').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/getSpek`,
              "type": "POST",
              "data": {
                kodebarang : table.cell( idx, 4).data()
              }
          },
          "columns": [
            { "data": "no" }, 
            { "data": "id" , "visible" : false},
            { "data": "sn" },
            { "data": "namabarang" },
            { "data": "ket" },
            { "data": "namadesign" },
            { "data": "gambardesign" },
            { "data": "kodewarna" },
            { "data": "opsi" },
          ]
      });

  }

  function add_data() {
      state = 'add';
      $('#form-data')[0].reset();
      $('[name="ref_brg"]').val(table.cell( idx, 4).data());
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.select2').trigger('change');
      $('.modal-title').text('Tambah Data');
  }

  function edit_data() {
      id = table.cell( idx, 1).data();
      if (idx == -1) {
          return false;
      }
      state = 'update';
      $('#form-data')[0].reset();
      $.ajax({
          url: `${apiurl}/edit`,
          type: "POST",
          data: {
              id: id,
          },
          dataType: "JSON",
          success: function(data) {
              $('[name="idsatbarang"]').val(data.idsatbarang);
              $('[name="idbarang"]').val(data.idbarang);
              $('[name="nama"]').val(data.namabarang);
              $('[name="konv"]').val(data.konv);
              $('[name="harga"]').val(data.harga);
              $('[name="ket"]').val(data.ket);
              $('[name="ref_sat"]').val(data.ref_sat);
              $('[name="ref_gud"]').val(data.ref_gud);
              $('.select2').trigger('change');
              $('#modal-data').modal('show');
              $('.modal-title').text('Edit Data');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function savedata() {
      var url;
      if (state == 'add') {
          url = `${apiurl}/savedata`;
      } else {
          url = `${apiurl}/updatedata`;
      }
      $.ajax({
          url: url,
          type: "POST",
          data: $('#form-data').serializeArray(),
          dataType: "JSON",
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-data').modal('hide');
                  refreshspek();
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
                  $('.modal-title').text('Spesifikasi Produk');
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refreshspek();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
                  $('.modal-title').text('Spesifikasi Produk');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger')
          }
      });
  }

  function hapus_data(id) {
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_spek(' + id + ')');
  }

  function delete_spek(id) {
      $.ajax({
          url: `${apiurl}/deletespek`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  refreshspek();
                  showNotif('Sukses', 'Data Berhasil Dihapus', 'success')
                  $('.modal-title').text('Spesifikasi Produk');
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refreshspek();
                  showNotif('Gagal', 'Data Gagal Dihapus', 'danger')
                  $('.modal-title').text('Spesifikasi Produk');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  </script>
</body>
</html>