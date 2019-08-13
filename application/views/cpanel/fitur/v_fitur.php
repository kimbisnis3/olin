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
                        <div class="row panel panel-success" >
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="hidden" name="id" >
                              <label>Nama</label>
                              <input type="text" name="nama_action" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Kategori</label>
                              <input type="text" name="kategori_menu" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Handle</label>
                              <input type="text" name="application_handle" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row panel panel-success">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Group</label>
                              <select class="form-control" name="group_action" id="groupMenu">
                                <option value="">--</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Icon</label>
                              <input type="text" name="icon_action" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Urutan</label>
                              <input type="number" name="sort_menu" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="row panel panel-success">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Url</label>
                              <input type="text" name="url" class="form-control">
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
                      <button class="btn btn-primary btn-flat add-btn" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="pull-right">
                      <button class="btn btn-warning btn-flat edit-btn" onclick="edit_data()"><i class="fa fa-pencil"></i> Ubah</button>
                      <button class="btn btn-danger btn-flat delete-btn" onclick="hapus_data()" ><i class="fa fa-trash"></i> Hapus</button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive mailbox-messages">
                      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr id="repeat">
                            <th width="2%">No.</th>
                            <th width="2%">ID.</th>
                            <th>Nama Fitur</th>
                            <th>Kategori</th>
                            <th>Handle Aplikasi</th>
                            <th>ID Key</th>
                            <th>Group</th>
                            <th>Nama Icon</th>
                            <th>Icon</th>
                            <th>Urutan</th>
                            <th>Url</th>
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
  var path = 'cpanel/fitur';
  var title = 'Fitur Aplikasi';
  var grupmenu = 'Cpanel';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      $('.title').text('Fitur Aplikasi');
      select2();
      activemenux('menu-dev', 'menu-dev-fitur')

      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {},
          },
          "columns": [
          { "data": "no" }, 
          { "data": "id" , "visible" : false},
          { "data": "nama_action" },
          { "data": "kategori_menu" },
          { "data": "application_handle" },
          { "data": "id" },
          { "data": "group_action" },
          { "data": "icon_action" },
          { "data": "icon" },
          { "data": "sort_menu" },
          { "data": "url" },
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
              $('[name="id"]').val(data.id_action);
              $('[name="nama_action"]').val(data.nama_action);
              $('[name="application_handle"]').val(data.application_handle);
              $('[name="group_action"]').val(data.group_action);
              $('[name="icon_action"]').val(data.icon_action);
              $('[name="sort_menu"]').val(data.sort_menu);
              $('[name="kategori_menu"]').val(data.kategori_menu);
              $('[name="url"]').val(data.url);
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

  function getGroupMenu() {
      $.ajax({
          url: '<?php echo base_url() ?>universe/getGroupMenu',
          type: "POST",
          dataType: "JSON",
          success: function(data) {
              for (var i = 0; i < data.length; i++) {
                  $("#groupMenu").append('<option value=' + data[i].kode + '>' + data[i].group_action + '</option>');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });

  }

  </script>
</body>
</html>