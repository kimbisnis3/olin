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
        <div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <div class="box-body pad">
                  <form id="form-data">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="form-group">
                          <label>Nama</label>
                          <input type="hidden" name="idbarang">
                          <input type="hidden" name="idsatbarang">
                          <input type="hidden" name="kode">
                          <input type="text" class="form-control" name="nama">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Keterangan</label>
                          <input type="text" class="form-control" name="ket" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Kode Design</label>
                          <input type="text" class="form-control" name="sn">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Model</label>
                          <select class="form-control select2" name="model">
                            <option value="">-</option>
                            <?php foreach ($design as $i => $v): ?>
                            <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Warna</label>
                          <select class="form-control select2" name="warna">
                            <option value="">-</option>
                            <?php foreach ($warna as $i => $v): ?>
                            <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Keterangan</label>
                          <input type="text" class="form-control" name="ketspek">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="box box-info">
                <div class="box-header">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Konv</label>
                        <input type="number" class="form-control" name="konv" >
                        <input type="hidden" class="form-control" name="idsatuan" >
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Satuan</label>
                        <select class="form-control select2" name="ref_sat">
                          <option value="">-</option>
                          <?php foreach ($satuan as $i => $v): ?>
                          <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga" >
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Keterangan Harga</label>
                        <input type="text" class="form-control" name="ketsatuan" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="pull-right">
                      <button style="margin-right: 19px!important" type="button" class="btn btn-primary btn-flat add-btn bounceIn animated" onclick="add_harga()" id="btn-tambah-harga"><i class="fa fa-plus"></i> Tambah</button>
                      <button style="margin-right: 19px!important" type="button" class="btn btn-warning btn-flat add-btn bounceIn animated" onclick="simpan_harga()" id="btn-simpan-harga"><i class="fa fa-save"></i> Simpan</button>
                      <button style="margin-right: 19px!important" type="button" class="btn btn-danger btn-flat add-btn bounceIn animated" onclick="batal_harga()" id="btn-batal-harga"><i class="fa fa-times"></i> Batal</button>
                    </div>
                  </div>
                </div>
                <div class="box-body pad">
                  <div class="table-responsive mailbox-messages box-table-harga">
                    <table id="table-harga" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr id="repeat">
                          <th>Konv</th>
                          <th>Satuan</th>
                          <th>Harga</th>
                          <th>Keterangan</th>
                          <th>Default</th>
                          <th width="15%">Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                  <div class="table-responsive mailbox-messages box-table-harga-edit">
                    <table id="table-harga-edit" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr id="repeat">
                          <th>ID</th>
                          <th>Konv</th>
                          <th>Satuan</th>
                          <th>Harga</th>
                          <th>Keterangan</th>
                          <th>Default</th>
                          <th width="15%">Opsi</th>
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
                      <button class="btn btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="pull-right">
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
                            <th>ID Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Konv</th>
                            <th>Nama Satuan</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Nama Gudang</th>
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
  var table ;
  var tablehargaedit ;
  var sat   = [];
  var arrsat = JSON.stringify(sat);

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
          //data 0 for detail-controls
          { "data": "no" }, 
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "idbarang" , "visible" : false},
          { "data": "namabarang" },
          { "data": "konv", "visible" : false },
          { "data": "namasatuan" },
          { "data": "harga" },
          { "data": "ketbarang" },
          { "data": "namagudang", "visible" : false }
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

    tableharga = $('#table-harga').DataTable({
          "processing": true,
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "destroy" : true,
          "data": $.parseJSON(arrsat),
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>"
          }],
          "columns": [
          { "data": "konv" },
          { "data": "satuan" },
          { "data": "harga" },
          { "data": "ketsatuan" },
          { "data": "deflabel" },
          { "data": "btn"}
          ]
      });

      $('#table-harga tbody').on( 'click', 'button', function () {
        var data = tableharga.row( $(this).parents('tr') ).data();
        let i = _.findIndex(sat, { 
          'konv'  : data.konv, 
          'satuan': data.satuan,
          'harga' : data.harga 
        });
        sat.splice(i, 1);
        console.log(sat);
        reloadharga();
    } );
  });

  function format(callback, data) {
      $.ajax({
          url: `${apiurl}/getdetail`,
          type: "POST",
          data: {
            kodebarang : data.kode
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

  function add_harga() {
      if (state == 'add') {
        let defvalue;
        let deflabel;
        if (sat.filter(st => st.konv == '1').length && $('[name="konv"]').val() == '1') {
            showNotif('Warning', 'Konv 1 Sudah Ada', 'warning')
        } else {
          if ($('[name="konv"]').val() == '1') {
            defvalue = 't'
            deflabel = '<span class="label label-success">Default</span>'
          } else {
            defvalue = ''
            deflabel = ''
          }
            sat.push({
                'konv': $('[name="konv"]').val(),
                'harga': $('[name="harga"]').val(),
                'ref_sat': $('[name="ref_sat"]').val(),
                'satuan': $('[name="ref_sat"] option:selected').html(),
                'ketsatuan': $('[name="ketsatuan"]').val(),
                'def': defvalue,
                'deflabel': deflabel,
            });
            reloadharga();
            clearformsat()
        }
        
        
      } else if (state == 'update') {
        if (ceknull('konv')) { return false }
        if (ceknull('harga')) { return false }
        if (ceknull('ref_sat')) { return false }
        if (ceknull('ket')) { return false }
        param = {
          'ref_brg': $('[name="kode"]').val(),
          'konv': $('[name="konv"]').val(),
          'harga': $('[name="harga"]').val(),
          'ref_sat': $('[name="ref_sat"]').val(),
          'def': '',
          'ketsatuan': $('[name="ketsatuan"]').val()
        }
        unipost(`${apiurl}/addharga`, param, function(res) {
            if (res.sukses == "success") {
                clearformsat()
                state_insatuan()
                tablehargaedit.ajax.reload(null, false);
                refresh();
                showNotif('Sukses', 'Data Harga Berhasil Ditambahkan', 'success')
            }
        })
      }
  }

  function edit_harga(id) {
      Pace.restart();
      unipost(`${apiurl}/editharga`, { id : id }, function(data) {
          $('[name="konv"]').val(data.konv);
          $('[name="idsatuan"]').val(id);
          $('[name="harga"]').val(data.harga);
          $('[name="ref_sat"]').val(data.ref_sat);
          $('[name="ketsatuan"]').val(data.ket);
          $('.select2').trigger('change');
      })
      state_edsatuan();
  }

  function batal_harga() {
      state_insatuan()
      clearformsat()
  }

  function simpan_harga() {
      param = {
          'id': $('[name="idsatuan"]').val(),
          'konv': $('[name="konv"]').val(),
          'harga': $('[name="harga"]').val(),
          'ref_sat': $('[name="ref_sat"]').val(),
          'ketsatuan': $('[name="ketsatuan"]').val()
      }
      unipost(`${apiurl}/updateharga`, param, function(res) {
          if (res.sukses == "success") {
              clearformsat()
              state_insatuan()
              tablehargaedit.ajax.reload(null, false);
              refresh();
              showNotif('Sukses', 'Data Harga Berhasil Ditambahkan', 'success')
          }
      })
  }

  function reloadharga() {
      a = JSON.stringify(sat);
      tableharga.clear().rows.add($.parseJSON(a)).draw();
  }

  function clearformsat() {
      $('[name="konv"]').val('');
      $('[name="harga"]').val('');
      $('[name="ref_sat"]').val('');
      $('[name="ketsatuan"]').val('');
      $('.select2').trigger('change');
  }

  function state_edsatuan() {
      $('#btn-tambah-harga').addClass('invisible')
      $('#btn-batal-harga').removeClass('invisible')
      $('#btn-simpan-harga').removeClass('invisible')
  }

  function state_insatuan() {
      $('#btn-tambah-harga').removeClass('invisible')
      $('#btn-batal-harga').addClass('invisible')
      $('#btn-simpan-harga').addClass('invisible')
  }

  function add_data() {
      state = 'add';
      sat   = [];
      reloadharga()
      $('#form-data')[0].reset();
      $('.box-table-harga-edit').addClass('invisible');
      $('.box-table-harga').removeClass('invisible');
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.select2').trigger('change');
      $('.modal-title').text('Tambah Data');
      state_insatuan()
  }

  function edit_data() {
      kode = table.cell( idx, 3).data();
      if (idx == -1) {
          return false;
      }
      state = 'update';
      $('#form-data')[0].reset();
      $.ajax({
          url: `${apiurl}/edit`,
          type: "POST",
          data: {
              kode: kode,
          },
          dataType: "JSON",
          success: function(data) {
              //barang
              $('[name="idbarang"]').val(data.barang.idbarang);
              $('[name="nama"]').val(data.barang.nama);
              $('[name="ket"]').val(data.barang.ket);
              $('[name="kode"]').val(data.barang.kode);

              //spek barang
              if (data.spek) {
                $('[name="sn"]').val(data.spek.sn);
                $('[name="model"]').val(data.spek.model);
                $('[name="warna"]').val(data.spek.warna);
                $('[name="ketspek"]').val(data.spek.ket); 
              }

              //detail satuan barang
              // sat = data.harga;
              // reloadharga();
              $('.box-table-harga').addClass('invisible');
              $('.box-table-harga-edit').removeClass('invisible');
              state_insatuan();
              tablehargaedit = $('#table-harga-edit').DataTable({
                  "processing": true,
                  "destroy" : true,
                  "ajax": {
                      "url": `${apiurl}/getdetailharga`,
                      "type": "POST",
                      "data": {
                        kodebarang : data.barang.kode
                      },
                  },
                  "columns": [
                  { "data": "id" , "visible" : false},
                  { "data": "konv" },
                  { "data": "namasatuan" },
                  { "data": "harga" },
                  { "data": "ket" },
                  { "data": "def" },
                  { "data": "btn" },
                  ]
              });

              $('#table-harga-edit tbody').on( 'click', '#hapussat', function () {
                var data = tablehargaedit.row( $(this).parents('tr') ).data();
                hapus_harga(data.id);
              } );
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
      if (ceknull('nama')) { return false }
      if (ceknull('ket')) { return false }
      var url;
      if (state == 'add') {
          url = `${apiurl}/savedata`;
      } else {
          url = `${apiurl}/updatedata`;
      }
      $.ajax({
          url: url,
          type: "POST",
          data: {
            idbarang    : $('[name="idbarang"]').val(),
            kode        : $('[name="kode"]').val(),
            idsatbarang : $('[name="idsatbarang"]').val(),
            nama        : $('[name="nama"]').val(),
            ket         : $('[name="ket"]').val(),
            ref_gud     : $('[name="ref_gud"]').val(),

            sn          : $('[name="sn"]').val(),
            model       : $('[name="model"]').val(),
            warna       : $('[name="warna"]').val(),
            ketspek     : $('[name="ketspek"]').val(),

            arrHarga    : JSON.stringify(sat)
          },
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

  function default_data(id) {
      $('.modal-title').text('Default Produk ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'do_default_data(' + id + ')');
  }

  function do_default_data(id) {
      $.ajax({
          url: `${apiurl}/default_data`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  tablehargaedit.ajax.reload(null, false);
                  table.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-konfirmasi').modal('hide');
                  tablehargaedit.ajax.reload(null, false);
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function hapus_data() {
      idbarang = table.cell( idx, 4).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_data(' + idbarang + ')');
  }

  function delete_data(idbarang) {
      $.ajax({
          url: `${apiurl}/deletedata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: idbarang,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil Dihapus', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Gagal', 'Data Gagal Dihapus', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function hapus_harga(id) {
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_harga(' + id + ')');
  }

  function delete_harga(id) {
      $.ajax({
          url: `${apiurl}/deleteharga`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  tablehargaedit.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Harga Berhasil Dihapus', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-konfirmasi').modal('hide');
                  refresh();
                  showNotif('Gagal', 'Data Harga Gagal Dihapus', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              $('#modal-konfirmasi').modal('hide');
              showNotif('Gagal', 'Barang Sudah Digunakan', 'danger');
          }
      });
  }

  </script>
</body>
</html>