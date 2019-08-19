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
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Gudang</label>
                              <select class="form-control select2" name="ref_gud">
                                <option> - </option>
                                <?php foreach ($gudang as $i => $v): ?>
                                <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Tanggal</label>
                              <input type="text" class="form-control datepicker" name="tgl">
                              <input type="hidden" class="form-control" name="ref_satbrg" readonly="true">
                            </div>
                            <div class="form-group">
                              <label>Keterangan</label>
                              <input type="ket" class="form-control" name="ket">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Produk</label>
                              <input type="hidden" name="ref_brg">
                              <div class="input-group">
                                <input type="text" class="form-control" name="namabarang" readonly="true">
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-primary btn-flat" onclick="open_barang()"><i class="fa fa-table"></i></button>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Jumlah</label>
                              <input type="number" class="form-control" name="jumlah">
                            </div>
                          </div>
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
          <div class="modal fade" id="modal-barang" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Daftar Produk</h4>
                </div>
                <div class="modal-body">
                  <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body pad">
                      <div class="table-responsive mailbox-messages">
                        <table id="table-barang" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="5%">No</th>
                              <th>ID</th>
                              <th>Kode</th>
                              <th>Ref Brg</th>
                              <th>Ref SatBrg</th>
                              <th>Nama</th>
                              <th>Konv</th>
                              <th>Satuan</th>
                              <th>Harga</th>
                              <th>Keterangan</th>
                              <th>Opsi</th>
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
                        <button class="btn btn-act btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                      </div>
                      <div class="pull-right">
                        <button class="btn btn-act btn-primary btn-flat add-btn invisible" onclick="add_data('in')" ><i class="fa fa-sign-in"></i> Barang Masuk</button>
                        <button class="btn btn-act btn-danger btn-flat add-btn invisible" onclick="add_data('out')" ><i class="fa fa-sign-out"></i> Barang Keluar</button>
                      </div>
                    </div>
                    <div class="box-body">
                      <div class="table-responsive mailbox-messages">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="5%">No</th>
                              <th>ID</th>
                              <th>Gudang</th>
                              <th>Jumlah</th>
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
  var path = 'stokproduk';
  var title = 'Stok Produk';
  var grupmenu = 'Transaksi';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table;
  var setgud;

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('transaksi', 'stokproduk');
      dpicker();

      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {},
          },
          "columns": [
          { "data": "id", "note" : "numbers" }, 
          { "data": "id" , "visible" : false},
          { "data": "mgudang_nama" },
          { "data": "jumlah" },
          ]
      });

    table.on( 'order.dt search.dt', function () {
        table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

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

  });

  function open_barang() {
      $('#modal-barang').modal('show');
      tablebarang = $('#table-barang').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/getbrg`,
              "type": "POST",
              "data": {}
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
          }],
          "columns": [
            { "data": "no" }, 
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : false},
            { "data": "ref_satbrg" , "visible" : false},
            { "data": "ref_brg" , "visible" : false},
            { "data": "nama" },
            { "data": "konv" },
            { "data": "namasatuan" },
            { "data": "harga" },
            { "data": "ket" },
            { "data": "opsi" },
          ]

      });

      $('#table-barang tbody').on('click', 'button', function() {
          var data = tablebarang.row($(this).parents('tr')).data();
          $('[name="namabarang"]').val(data.nama);
          $('[name="ref_satbrg"]').val(data.ref_satbrg);
          $('[name="ref_brg"]').val(data.ref_brg);
          $('#modal-barang').modal('hide');
      });

  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function add_data(tipe) {
      state = 'add';
      var mdtitle;
      if (tipe == 'in') {
        setgud = 'gud_in';
        mdtitle = 'Barang Masuk'
      } else {
        setgud = 'gud_out';
        mdtitle = 'Barang Keluar'
      }
      $('#form-data')[0].reset();
      clearform();
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.select2').trigger('change');
      $('.modal-title').text('Tambah Data');
  }

  function savedata() {
      if (ceknull('namabarang')) { return false }
      var url;
      if (setgud == 'gud_in') {
          url = `${apiurl}/savedata_in`;
      } else {
          url = `${apiurl}/savedata_out`;
      }
      $.ajax({
          url: url,
          type: "POST",
          data: $('#form-data').serializeArray(),
          dataType: "JSON",
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-data').modal('hide');
                  refresh();
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger')
          }
      });
  }



  </script>
</body>
</html>