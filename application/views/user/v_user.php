<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
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
  <div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <!-- Modal content-->
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
                  <label>Username</label>
                  <input type="hidden" name="id">
                  <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" name="password" >
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" >
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" name="alamat" >
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-flat">Simpan</button>
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
          <button type="button" id="btnHapus"  class="btn btn-danger btn-flat">Ya</button>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <button class="btn btn-success btn-flat" onclick="refresh()"  title="Cek Data"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            <button class="btn btn-warning btn-flat" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
          </div>
          <div class="box-body">
            <div class="table-responsive mailbox-messages">
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr id="repeat">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Alamat</th>
                    <th>Status</th>
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
    </div>
  </section>
  </div><!-- /.content-wrapper -->
  <?php
  $this->load->view('template/js');
  ?>
  <script type="text/javascript">
  var controller = 'user';
  var table;
  var idx = -1;
  var urlmaindata = "<?php echo site_url('') ?>" + controller + '/setView';
  var urledit = "<?php echo site_url('')?>" + controller + '/edit';
  var urlsave = "<?php echo site_url('')?>" + controller + '/tambah';
  var urlsavefile = "<?php echo site_url('')?>" + controller + '/tambahfile';
  var urlupdate = "<?php echo site_url('')?>" + controller + '/update';
  var urlupdatefile = "<?php echo site_url('')?>" + controller + '/updatefile';
  var urlhapus = "<?php echo site_url('')?>" + controller + '/hapus';
  var urlunduh = "<?php echo site_url('')?>" + controller + '/unduh';
  var urlaktif = "<?php echo site_url('')?>" + controller + '/aktif';

  $(document).ready(function() {
      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": urlmaindata,
              "type": "POST",
              "data": {}
          },
          "columns": [{
                  "data": "no"
              }, 
              {
                  "data": "nama"
              },
              {
                  "data": "username"
              }, 
              {
                  "data": "password"
              }, 
              {
                  "data": "alamat"
              }, 
              {
                  "data": "aktif"
              }, 
              {
                  "data": "action"
              }
          ]
      });
  });


  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function add_data() {
      save_method = 'add';
      $('#form-data')[0].reset();

      $('#modal-data').modal('show');
      $('.modal-title').text('Tambahkan Data');
  }

  function edit_data(id) {
      save_method = 'update';
      $('#form-data')[0].reset();
      $.ajax({
          url: urledit,
          type: "POST",
          data: {
              id: id,
          },
          dataType: "JSON",
          success: function(data) {
              $('[name="id"]').val(data.id);
              $('[name="nama"]').val(data.nama);
              $('[name="username"]').val(data.username);
              $('[name="password"]').val(data.password);
              $('[name="alamat"]').val(data.alamat);
              
              $('#modal-data').modal('show');
              $('.modal-title').text('Edit Data');

          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function save() {
      var url;
      if (save_method == 'add') {
          url = urlsave;
          notif = showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success');
      } else {
          url = urlupdate;
          notif = showNotif('Sukses', 'Data Berhasil Diubah', 'success');
      }
      $.ajax({
          url: url,
          type: "POST",
          data: $('#form-data').serialize(),
          dataType: "JSON",
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-data').modal('hide');
                  refresh();
                  save_method == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }


          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function hapus_data(id) {
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_data(' + id + ')');
  }

  function delete_data(id) {
      $.ajax({
          url: urlhapus,
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
              refresh();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function aktif_data(id) {
      $.ajax({
          url: urlaktif,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              // $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  // $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
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