<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <style type="text/css">
    .uni-green {
      background-color: #66BB6A !important;
      color : #ffffff;
    }
    .uni-red {
        background-color: #ef5350 !important;
        color : #ffffff;
    }
    .selected {
        background-color: #008B8B !important;
        color: #ffffff !important;
    }
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
                          <label>Nama</label>
                          <input type="hidden" name="id">
                          <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="form-group">
                          <label>Jenis Agen</label>
                          <select class="form-control select2" name="ref_jenc">
                            <option value="">-</option>
                            <?php foreach ($jenc as $i => $v): ?>
                              <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Telp</label>
                          <input type="text" class="form-control" name="telp" >
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" class="form-control" name="email" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Alamat</label>
                          <input type="text" class="form-control" name="alamat" >
                        </div>
                        <div class="form-group">
                          <label>PIC</label>
                          <input type="text" class="form-control" name="pic" >
                        </div>
                        <div class="form-group">
                          <label>Keterangan</label>
                          <input type="text" class="form-control" name="ket" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Username</label>
                          <input type="text" class="form-control" name="user" >
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control" name="pass" >
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
                      <button class="btn btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="pull-right">
                      <button class="btn btn-warning btn-flat edit-btn invisible" onclick="edit_data()"><i class="fa fa-pencil"></i> Ubah</button>
                      <button class="btn btn-success btn-flat edit-btn invisible" onclick="aktif_data()"><i class="fa fa-check"></i> Aktif</button>
                      <button class="btn btn-danger btn-flat delete-btn invisible" onclick="hapus_data()" ><i class="fa fa-trash"></i> Hapus</button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive mailbox-messages">
                      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr id="repeat">
                            <th width="5%">No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jenis Agen</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Email</th>
                            <th>PIC</th>
                            <th>Ket</th>
                            <th>User</th>
                            <th>Pass</th>
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
  var path = 'dataagen';
  var title = 'Data Agen';
  var grupmenu = 'Master Data';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('masterdata', 'dataagen');

      table = $('#table').DataTable({
          "processing": true,
          "createdRow": function( row, data, dataIndex ) 
          {
            if ( data.aktif == "t" ) {        
              $(row).addClass('uni-green');
              console.log(row)
            }else {        
              $(row).addClass('uni-red');
            }
          },
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {},
          },
          "columns": [
          { "data": "no" }, 
          { "data": "id" , "visible" : false},
          { "data": "nama" }, 
          { "data": "jencust" },
          { "data": "alamat" },
          { "data": "telp" },
          { "data": "email" },
          { "data": "pic" },
          { "data": "ket" },
          { "data": "user" },
          { "data": "pass" },
          ]
      });

    $('#table tbody').on('click', 'tr', function() {
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

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function add_data() {
      state = 'add';
      $('#form-data')[0].reset();
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
              $('[name="id"]').val(data.id);
              $('[name="nama"]').val(data.nama);
              $('[name="alamat"]').val(data.alamat);
              $('[name="telp"]').val(data.telp);
              $('[name="email"]').val(data.email);
              $('[name="pic"]').val(data.pic);
              $('[name="ket"]').val(data.ket);
              $('[name="ref_jenc"]').val(data.ref_jenc);
              $('[name="user"]').val(data.user);
              $('[name="pass"]').val('');
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

  function aktif_data(id) {
    id = table.cell( idx, 1).data();
      $.ajax({
          url: `${apiurl}/aktifdata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  refresh();
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function hapus_data() {
      id = table.cell( idx, 1).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_data(' + id + ')');
  }

  function delete_data(id) {
      $.ajax({
          url: `${apiurl}/deletedata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
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

  </script>
</body>
</html>